<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerY5j4Mpx\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerY5j4Mpx/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerY5j4Mpx.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerY5j4Mpx\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerY5j4Mpx\App_KernelDevDebugContainer([
    'container.build_hash' => 'Y5j4Mpx',
    'container.build_id' => 'ed53a6e2',
    'container.build_time' => 1677061863,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerY5j4Mpx');
