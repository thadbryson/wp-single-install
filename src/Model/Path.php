<?php

namespace TCB\Model;

use TCB\Application;

class Path
{
    public static function get($path = '', $wpRoot = false)
    {
        // Get the root path.
        $root = dirname(dirname(__DIR__));

        if ($wpRoot) {
            $root = Application::getWpDir();
        }

        $path = $root . '/' . $path;
        $path = rtrim($path, '/');

        return str_replace('/', DIRECTORY_SEPARATOR, $path);
    }
}
