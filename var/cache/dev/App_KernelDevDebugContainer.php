<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerGxvpftq\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerGxvpftq/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerGxvpftq.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerGxvpftq\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerGxvpftq\App_KernelDevDebugContainer([
    'container.build_hash' => 'Gxvpftq',
    'container.build_id' => '5d621c6e',
    'container.build_time' => 1677053537,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerGxvpftq');
