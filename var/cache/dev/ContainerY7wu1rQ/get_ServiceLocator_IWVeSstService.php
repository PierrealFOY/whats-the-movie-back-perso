<?php

namespace ContainerY7wu1rQ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_IWVeSstService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.IWVeSst' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.IWVeSst'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'userPasswordHasherInterface' => ['privates', 'security.user_password_hasher', 'getSecurity_UserPasswordHasherService', true],
            'userRepository' => ['privates', 'App\\Repository\\UserRepository', 'getUserRepositoryService', true],
        ], [
            'userPasswordHasherInterface' => '?',
            'userRepository' => 'App\\Repository\\UserRepository',
        ]);
    }
}