<?php

namespace ContainerY7wu1rQ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_9s1SlxIService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.9s1SlxI' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.9s1SlxI'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'App\\Controller\\Back\\UserController::add' => ['privates', '.service_locator.IWVeSst', 'get_ServiceLocator_IWVeSstService', true],
            'App\\Controller\\Back\\UserController::delete' => ['privates', '.service_locator.4MF6DUv', 'get_ServiceLocator_4MF6DUvService', true],
            'App\\Controller\\Back\\UserController::edit' => ['privates', '.service_locator.KdRCMpG', 'get_ServiceLocator_KdRCMpGService', true],
            'App\\Controller\\Back\\UserController::show' => ['privates', '.service_locator.ch4Jgvl', 'get_ServiceLocator_Ch4JgvlService', true],
            'App\\Kernel::loadRoutes' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
            'App\\Kernel::registerContainerConfiguration' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
            'kernel::loadRoutes' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
            'kernel::registerContainerConfiguration' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
            'App\\Controller\\Back\\UserController:add' => ['privates', '.service_locator.IWVeSst', 'get_ServiceLocator_IWVeSstService', true],
            'App\\Controller\\Back\\UserController:delete' => ['privates', '.service_locator.4MF6DUv', 'get_ServiceLocator_4MF6DUvService', true],
            'App\\Controller\\Back\\UserController:edit' => ['privates', '.service_locator.KdRCMpG', 'get_ServiceLocator_KdRCMpGService', true],
            'App\\Controller\\Back\\UserController:show' => ['privates', '.service_locator.ch4Jgvl', 'get_ServiceLocator_Ch4JgvlService', true],
            'kernel:loadRoutes' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
            'kernel:registerContainerConfiguration' => ['privates', '.service_locator.KfbR3DY', 'get_ServiceLocator_KfbR3DYService', true],
        ], [
            'App\\Controller\\Back\\UserController::add' => '?',
            'App\\Controller\\Back\\UserController::delete' => '?',
            'App\\Controller\\Back\\UserController::edit' => '?',
            'App\\Controller\\Back\\UserController::show' => '?',
            'App\\Kernel::loadRoutes' => '?',
            'App\\Kernel::registerContainerConfiguration' => '?',
            'kernel::loadRoutes' => '?',
            'kernel::registerContainerConfiguration' => '?',
            'App\\Controller\\Back\\UserController:add' => '?',
            'App\\Controller\\Back\\UserController:delete' => '?',
            'App\\Controller\\Back\\UserController:edit' => '?',
            'App\\Controller\\Back\\UserController:show' => '?',
            'kernel:loadRoutes' => '?',
            'kernel:registerContainerConfiguration' => '?',
        ]);
    }
}
