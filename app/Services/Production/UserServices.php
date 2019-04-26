<?php

namespace App\Services\Production;

use App\Repositories\UserRepositoryInterface;
use App\Services\UserServicesInterface;

class UserServices extends BaseCrudServices implements UserServicesInterface
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }
}
