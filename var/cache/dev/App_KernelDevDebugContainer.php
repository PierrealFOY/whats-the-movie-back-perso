<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerUktb2ba\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerUktb2ba/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerUktb2ba.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerUktb2ba\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerUktb2ba\App_KernelDevDebugContainer([
    'container.build_hash' => 'Uktb2ba',
    'container.build_id' => '80961895',
    'container.build_time' => 1677141365,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerUktb2ba');