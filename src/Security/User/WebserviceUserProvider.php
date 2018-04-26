<?php

namespace App\Security\User;

use App\Entity\User;
use App\Security\User\WebserviceUser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class WebserviceUserProvider implements UserProviderInterface
{
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function loadUserByUsername($username)
    {
        // make a call to your webservice here
        $userData = $this->getDoctrine()->getRepository(User::class)->loadUserByUsername($username);
        // pretend it returns an array on success, false if there is no user

        if ($userData) {
            $currentUser = new WebserviceUser($userData);
            $this->container->set('user', $currentUser);
            return $currentUser;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return WebserviceUser::class === $class;
    }

    public function getUserService()
    {
        return $this->container->get('app.service.user.user_service');
    }

    public function getDoctrine()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }
}
