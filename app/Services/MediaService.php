<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use App\Repositories\MediaRepository;
use Illuminate\Database\Eloquent\Model;
use App\Services\Contracts\FileManagerInterface;

class MediaService
{
    /**
     * To initialize class objects/variables.
     *
     * @param MediaRepository $mediaRepository
     * @param FileManagerInterface $fileManagerService
     */
    public function __construct(
        private MediaRepository $mediaRepository,
        private FileManagerInterface $fileManagerService
    ) {
    }

    /**
     * Uploads the files and saves the records.
     *
     * @param UploadedFile $file
     * @param Model $model
     * @return void
     */
    public function store(UploadedFile $file, Model $model): void
    {
        $this->mediaRepository->create($this->uploadFile($file, $model));
    }

    /**
     * Upload the file to storage and save the details in media table.
     *
     * @param UploadedFile $file
     * @param Model $model
     * @return array
     */
    private function uploadFile(UploadedFile $file, Model $model): array
    {
        $uploadFileName = sprintf(
            '%s_%s.%s',
            Carbon::now()->timestamp,
            $file->getSize(),
            explode('/', $file->getClientMimeType())[1]
        );

        if ($this->fileManagerService->upload($file, 'images/' . $uploadFileName)) {
            return [
                'entity_type' => $model->getMorphClass(),
                'entity_id' => $model->id,
                'file_original_name' => $uploadFileName,
                'file_location' => 'images',
                'size' => $file->getSize(),
            ];
        }

        return [];
    }

    /**
     * Removes file from cloud storage.
     *
     * @param string $filePath
     * @return void
     */
    public function removeFile(string $filePath): void
    {
        $this->fileManagerService->remove($filePath);
    }

    /**
     * To prepare media with url.
     *
     * @param Media $mediaFile
     * @return void
     */
    public function prepareMediaUrl(Media $mediaFile): void
    {
        $mediaFile->url = $this->fileManagerService->retrieve(
            sprintf('%s/%s', $mediaFile->file_location, $mediaFile->file_original_name)
        );
    }
}
