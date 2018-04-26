<?php

namespace App\Service\User\Impl;

use App\Entity\User;
use App\Service\BaseService;
use App\Service\User\UserService;

class UserServiceImpl extends BaseService implements UserService
{
    public function getUser($id)
    {
        $user = $this->getDoctrineManager()->getRepository(User::class)->findAll();
        return $user;
    }
}
