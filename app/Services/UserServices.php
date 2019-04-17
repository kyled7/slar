<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserServices
{
    use CrudService;

    protected $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }
}
