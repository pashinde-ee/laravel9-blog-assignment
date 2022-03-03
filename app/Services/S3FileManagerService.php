<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\Contracts\FileManagerInterface;

class S3FileManagerService implements FileManagerInterface
{

    /**
     * Returns media URL's.
     *
     * @param string $filePath
     * @return string
     */
    public function retrieve(string $filePath): string
    {
        return Storage::disk('s3')->url($filePath);
    }

    /**
     * Removes file from s3.
     *
     * @param string $filePath
     * @return void
     */
    public function remove(string $filePath): void
    {
        if (Storage::disk('s3')->exists($filePath)) {
            Storage::disk('s3')->delete($filePath);
        }
    }

    /**
     * Upload the files to S3.
     *
     * @param UploadedFile $file
     * @param string $filePath
     * @param string $visibility
     * @return bool
     */
    public function upload(UploadedFile $file, string $filePath, string $visibility = 'public'): bool
    {
        return Storage::disk('s3')
            ->put(
                $filePath,
                file_get_contents(sprintf('%s/%s', $file->getPath(), $file->getBasename())),
                [$visibility]
            );
    }
}
