<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Media;
use App\Repositories\Contracts\Repository;

class MediaRepository extends Repository
{
    /**
     * To initialize class objects/variables.
     *
     * @param Media $model
     */
    public function __construct(Media $model)
    {
        $this->model = $model;
    }
}
