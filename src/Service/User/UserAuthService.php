<?php

namespace App\Service\User;

use App\Entity\User;

interface UserAuthService
{
    public function register($user): User;
}
