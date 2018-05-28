<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use DB;
use Throwable;
use Exception;
use League\Csv\Reader;
use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Filesystem\Filesystem;
use OneUpReviews\Handlers\ImportedFileHandler;

class ClientCSVService
{
    public const HEADER_FIELDS = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * @var ClientService
     */
    protected $clientService;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @param ClientService $clientService
     * @param Filesystem $filesystem
     */
    public function __construct(ClientService $clientService, Filesystem $filesystem)
    {
        $this->clientService = $clientService;
        $this->fileSystem = $filesystem;
    }

    /**
     * @param string $path
     * @return Reader
     */
    public function readUploadedFile(string $path): Reader
    {
        return Reader::createFromPath($path);
    }

    /**
     * @param array $header
     * @return bool
     */
    public function fileHeaderMatchesRequirements(array $header): bool
    {
        return ! array_diff($header, self::HEADER_FIELDS) && ! array_diff(self::HEADER_FIELDS, $header);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function renameAndStoreFile(UploadedFile $file): string
    {
        $fileName = $this->renameFile($file);

        // store file to csv dir and rename to new name
        $fileName = $file->storeAs('csv', $fileName);

        return $this->fileSystem->getDriver()->getAdapter()->getPathPrefix() . $fileName;
    }

    /**
     * @param UploadedFile $file
     * @param Reader $records
     * @return ImportedFileHandler
     * @throws Exception
     * @throws Throwable
     */
    public function processAndStoreFile(UploadedFile $file, Reader $records): ImportedFileHandler
    {
        return DB::transaction(function() use ($file, $records) {

            // get array of existing clients.
            $existingClientsEmails = $this->clientService->getAll()->pluck('email_address')->toArray();

            $importHandler = new ImportedFileHandler;

            $importHandler->setUploadedFile($file);

            foreach($records->getIterator() as $record) {
                // Iterate over each row of data and clean the values.
                foreach((array) $record as $key => $value) {
                    // Trim each value
                    $value = trim($value);

                    // Remove all quotes
                    $value = preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $value);

                    // Set the key's value back with newly cleaned values
                    $record[$key] = $value;
                }

                // If total count of records does not match required fields
                // or if email is not valid email, skip;
                if (count($record) !== count(self::HEADER_FIELDS) || ! filter_var($record['email'], FILTER_VALIDATE_EMAIL)) {
                    $importHandler->addSkipped($record);
                    continue;
                }

                // If email is duplicate, skip it.
                if (in_array($record['email'], $existingClientsEmails, true)) {
                    $importHandler->addDuplicate($record);
                    continue;
                }

                $this->clientService->create(
                    $record['first_name'],
                    $record['last_name'],
                    $record['email']
                );

                $importHandler->addInserted($record);

                // update existing clients array.
                $existingClientsEmails[] = $record['email'];
            }

            return $importHandler;
        });
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function renameFile(UploadedFile $file): string
    {
        $fileName = $file->getClientOriginalName();
        $extension = $file->extension();

        // Replace last occurrence of extension with empty, the slugify, then re-attach extension.
        return str_slug(str_replace_last($extension, null, $fileName)) . '.' . $extension;
    }
}
