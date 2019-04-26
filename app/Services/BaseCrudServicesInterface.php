<?php
namespace App\Services;

interface BaseCrudServicesInterface
{
    public function index();

    public function create(array $attributes);

    public function read($id);

    public function update(array $attributes, $id);

    public function delete($id);

    public function getPaginate(int $perPage = null, bool $orderBy = true, array $column = ['*']);

    public function getPaginateWithFilter(
        array $filters = [],
        int $perPage = null,
        bool $orderBy = true,
        array $column = ['*']
    );

    public function getAllWithFilter(
        array $filters = [],
        bool $orderBy = true,
        array $column = ['*']
    );
}
