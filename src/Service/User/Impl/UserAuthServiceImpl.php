<?php

namespace App\Service\User\Impl;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Service\BaseService;
use App\Service\User\UserAuthService;

class UserAuthServiceImpl extends BaseService implements UserAuthService
{
    public function register($user): User
    {
        $password = $this->getPasswordEncoder()->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $userProfile = new UserProfile();
        $userProfile->setUser($user);
        $user->setUserProfile($userProfile);

        $entityManager = $this->getDoctrineManager();
        $entityManager->persist($user);
        $entityManager->persist($userProfile);
        $entityManager->flush();
        return $user;
    }

    public function getPasswordEncoder()
    {
        return $this->container->get('security.password_encoder');
    }
}
