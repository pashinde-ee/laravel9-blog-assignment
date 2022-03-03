<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;

interface FileManagerInterface
{
    /**
     * Returns media URL's.
     *
     * @param string $filePath
     * @return string
     */
    public function retrieve(string $filePath): string;

    /**
     * Removes file from storage.
     *
     * @param string $filePath
     * @return void
     */
    public function remove(string $filePath): void;

    /**
     * Upload the files to storage disk.
     *
     * @param UploadedFile $file
     * @param string $filePath
     * @param string $visibility
     * @return bool
     */
    public function upload(UploadedFile $file, string $filePath, string $visibility): bool;
}
