<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Handlers;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use Illuminate\Http\UploadedFile;

class ImportedFileHandler implements Countable, IteratorAggregate
{
    private static $results = [
        'skipped' => [],
        'inserted' => [],
        'duplicated' => []
    ];

    /**
     * @var UploadedFile
     */
    protected $uploadedFile;

    public function getSkippedRecords(): array
    {
        return self::$results['skipped'];
    }

    public function getInsertedRecords(): array
    {
        return self::$results['inserted'];
    }

    public function getDuplicateRecords(): array
    {
        return self::$results['duplicated'];
    }

    public function addInserted(array $insertedRecord): void
    {
        self::$results['inserted'][] = $insertedRecord;
    }

    public function addSkipped(array $skippedRecord): void
    {
        self::$results['skipped'][] = $skippedRecord;
    }

    public function addDuplicate(array $duplicate): void
    {
        self::$results['duplicated'][] = $duplicate;
    }

    public function getResults(): array
    {
        return self::$results;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getResults());
    }

    public function count(): int
    {
        return count($this->getResults());
    }

    public function setUploadedFile(UploadedFile $file): UploadedFile
    {
        return $this->uploadedFile = $file;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
