<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
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

    /**
     * Return the collection of all the records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Updates the records.
     *
     * @param int $id
     * @param array $attributes
     * @return int
     */
    public function update(int $id, array $attributes): int
    {
        return $this->model->where('id', $id)->update($attributes);
    }

    /**
     * Delete a model using id.
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }
}
