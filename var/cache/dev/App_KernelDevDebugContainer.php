<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerMZ5R0Je\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerMZ5R0Je/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerMZ5R0Je.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerMZ5R0Je\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerMZ5R0Je\App_KernelDevDebugContainer([
    'container.build_hash' => 'MZ5R0Je',
    'container.build_id' => '25f4f502',
    'container.build_time' => 1677163188,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerMZ5R0Je');
