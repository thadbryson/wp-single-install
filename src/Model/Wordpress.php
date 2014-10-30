<?php

namespace TCB\Model;

class Wordpress
{


    public static function getThemes()
    {
        $themes   = array();
        $themeDir = Path::get('/wp-content/themes', true);

        foreach (scandir($themeDir) as $theme) {

            if (is_dir($themeDir . DIRECTORY_SEPARATOR . $theme) && $theme !== '.' && $theme !== '..') {
                $themes[] = $theme;
            }
        }

        return $themes;
    }
}
