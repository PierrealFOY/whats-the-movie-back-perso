<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container0t8ZxSi\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container0t8ZxSi/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container0t8ZxSi.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container0t8ZxSi\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container0t8ZxSi\App_KernelDevDebugContainer([
    'container.build_hash' => '0t8ZxSi',
    'container.build_id' => 'f6e453e8',
    'container.build_time' => 1677162462,
], __DIR__.\DIRECTORY_SEPARATOR.'Container0t8ZxSi');
