<?php
namespace App\Services\Production;

use App\Services\BaseCrudServicesInterface;

abstract class BaseCrudServices implements BaseCrudServicesInterface
{

    /**
     * @var \App\Repositories\BaseRepositoryInterface
     */
    protected $repository;

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

    public function getPaginate(int $perPage = null, bool $orderBy = true, array $column = ['*'])
    {
        return $this->repository->getPaginate($perPage, $orderBy, $column);
    }

    public function getPaginateWithFilter(
        array $filters = [],
        int $perPage = null,
        bool $orderBy = true,
        array $column = ['*']
    ) {
        return $this->repository->getPaginateWithFilter($filters, $perPage, $orderBy, $column);
    }

    public function getAllWithFilter(
        array $filters = [],
        bool $orderBy = true,
        array $column = ['*']
    ) {
        return $this->repository->getAllWithFilter($filters, $orderBy, $column);
    }
}
