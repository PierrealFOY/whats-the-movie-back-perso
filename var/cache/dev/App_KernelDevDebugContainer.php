<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerIsoZ9zE\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerIsoZ9zE/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerIsoZ9zE.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerIsoZ9zE\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerIsoZ9zE\App_KernelDevDebugContainer([
    'container.build_hash' => 'IsoZ9zE',
    'container.build_id' => 'd74af81d',
    'container.build_time' => 1677161128,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerIsoZ9zE');
