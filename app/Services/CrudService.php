<?php

namespace App\Services;


trait CrudService
{
    public function index()
    {
        return $this->repository->getAll();
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function read($id)
    {
        return $this->repository->find($id);
    }

    public function update(array $attributes, $id)
    {
        return $this->repository->update($id, $attributes);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}