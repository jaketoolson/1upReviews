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
    private $results = [
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
        return $this->results['skipped'];
    }

    public function getInsertedRecords(): array
    {
        return $this->results['inserted'];
    }

    public function getDuplicateRecords(): array
    {
        return $this->results['duplicated'];
    }

    public function addInserted(array $insertedRecord): void
    {
        $this->results['inserted'][] = $insertedRecord;
    }

    public function addSkipped(array $skippedRecord): void
    {
        $this->results['skipped'][] = $skippedRecord;
    }

    public function addDuplicate(array $duplicate): void
    {
        $this->results['duplicated'][] = $duplicate;
    }

    public function getResults(): array
    {
        return $this->results;
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
