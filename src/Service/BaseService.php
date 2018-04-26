<?php

namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class BaseService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function getDoctrineManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

    protected function getCurrentUser()
    {
        if ($this->container->has('user')) {
            return $this->container->get('user');
        }
        $user = new User();
        $user->setUsername('unknown');
        return $user;
    }

//    protected function getLogger()
//    {
//        return $this->container->get('logger');
//    }

}
