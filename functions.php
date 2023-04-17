<?php

spl_autoload_register(function ($class) {
    $namespace = 'DomenART\Theme\\';
    $path = 'inc';

    // Bail if the class is not in our namespace.
    if (0 !== strpos($class, $namespace)) {
        return;
    }

    // Remove the namespace.
    $class = str_replace($namespace, '', $class);

    // Build the filename.
    $file = realpath(__DIR__ . "/{$path}");
    $file = $file . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // If the file exists for the class name, load it.
    if (file_exists($file)) {
        include ($file);
    }
});

/**
 * Load all services
 */
add_action(
    'after_setup_theme',
    function () {
        // Boot the service, at after_setup_theme.
        \DomenART\Theme\Framework::get_container()->boot_services();
    }
);
