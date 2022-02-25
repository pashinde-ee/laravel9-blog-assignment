<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * Object of particular eloquent model.
     *
     * @var object $model
     */
    protected $model;

    /**
     * Create a model.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
}
