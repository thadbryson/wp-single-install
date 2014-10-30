<?php

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

$config = filter_input(INPUT_SERVER, 'SERVER_NAME') . '.php';

// Put the path to the wp-single-code config directory here.
$config = __DIR__ . "/../wp-single-code/app/sites/" . $config;

if (!file_exists($config)) {
    die('Config not setup.');
}

require_once($config);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
