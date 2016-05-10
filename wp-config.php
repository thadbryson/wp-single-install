<?php

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Open the Wordpress config file here.
require_once(__DIR__ . '/configs/' . getenv('WP_SITE_CODE') . '.php');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
