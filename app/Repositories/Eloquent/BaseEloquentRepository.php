<?php

namespace App\Repositories\Eloquent;


use App\Repositories\BaseRepositoryInterface;

abstract class BaseEloquentRepository implements BaseRepositoryInterface
{
    const PER_PAGE_DEFAULT = 20;
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Get one
     *
     * @param $id
     *
     * @return mixed
     */
    public function find($id, array $relationships = [])
    {
        $result = $this->model->with($relationships)->find($id);

        return $result;
    }

    /**
     * Create
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update
     *
     * @param       $id
     * @param array $attributes
     *
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }
        return false;
    }

    /**
     * Delete
     *
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Get data with paginate
     *
     * @param int|NULL $perPage
     * @param bool     $orderBy
     * @param array    $column
     *
     * @return mixed
     */
    public function getPaginate(int $perPage = null, bool $orderBy = true, array $column = ['*'])
    {
        $query = $this->model;
        if (!empty($column)) {
            $query = $query->select($column);
        }
        if ($orderBy) {
            $query = $query->orderByDESC('id');
        }

        return $query->paginate(!is_null($perPage) ? $perPage : '');
    }

    /**
     * Find where condition
     *
     * @param array $where
     * @param bool  $getFirst
     *
     * @return mixed
     */
    public function findWhere(array $where, bool $getFirst = false)
    {
        $query = $this->model->where($where);
        if ($getFirst) {
            return $query->first();
        }

        return $query->get();
    }

    /**
     * Get paginate data with filter
     *
     * @param array    $filters
     * @param int|null $perPage
     * @param bool     $orderBy
     * @param array    $column
     *
     * @return mixed
     */
    public function getPaginateWithFilter(
        array $filters = [],
        int $perPage = null,
        bool $orderBy = true,
        array $column = ['*']
    ) {
        $query = $this->model;
        if (!empty($column)) {
            $query = $query->select($column);
        }
        if (@$filters['conditions'] && count($filters['conditions'])) {
            $query = $this->loopCondition($filters, $query);
        }
        if ($orderBy) {
            $query = $query->orderByDESC('id');
        }

        return $query->paginate(!is_null($perPage) ? $perPage : self::PER_PAGE_DEFAULT);
    }

    /**
     * Get all data with filter
     *
     * @param array $filters
     * @param bool  $orderBy
     * @param array $column
     *
     * @return mixed
     */
    public function getAllWithFilter(array $filters = [], bool $orderBy = true, array $column = ['*'])
    {
        $query = $this->model;
        if (!empty($column)) {
            $query = $query->select($column);
        }

        if (@$filters['conditions'] && count($filters['conditions'])) {
            $query = $this->loopCondition($filters, $query);
        }
        if ($orderBy) {
            $query = $query->orderByDESC('id');
        }

        return $query->get();
    }

    /**
     * Loop conditions
     *
     * @param $filters
     * @param $query
     *
     * @return mixed
     */
    public function loopCondition($filters, $query)
    {
        foreach ($filters['conditions'] as $columnName => $condition) {
            $columnValue = isset($filters['options'][$columnName]) && !is_null($filters['options'][$columnName])
                ? $filters['options'][$columnName] : null;
            if (!is_null($columnValue)) {
                switch ($condition) {
                    case 'like':
                        $query = $query->where($columnName, $condition, '%'.$columnValue.'%');
                        break;
                    default:
                        $query = $query->where($columnName, $condition, $columnValue);
                        break;
                }
            }
        }

        return $query;
    }
}