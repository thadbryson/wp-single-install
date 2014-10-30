<?php

namespace TCB\Model;

use TCB\Model\Path;

class Site
{


    public static function getKeys()
    {
        $keys = function()
        {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@$%^&*()-_=+[]{}|;:,.<>?';
            $rand  = '';

            $charLength = strlen($chars) - 1;

            for ($i = 0; $i < 65; $i++) {
                $rand .= $chars[rand(0, $charLength)];
            }

            return $rand;
        };

        return array(
            'AUTH_KEY'          => $keys(),
            'SECURE_AUTH_KEY'   => $keys(),
            'LOGGED_IN_KEY'     => $keys(),
            'NONCE_KEY'         => $keys(),
            'AUTH_SALT'         => $keys(),
            'SECURE_AUTH_SALT'  => $keys(),
            'LOGGED_IN_SALT'    => $keys(),
            'NONCE_SALT'        => $keys()
        );
    }

    public static function isValidDomain($domain)
    {
        return preg_match('/^([a-zA-Z0-9-_]*)\.*([a-zA-Z0-9\-\_]*)\.([a-zA-Z0-9]*)$/', $domain);
    }

    public static function build($config, $domain)
    {
        if (!static::isValidDomain($domain)) {
            throw new \RuntimeException('Invalid domain name: '.$domain);
        }

        // Now build the config file.
        $template       = file_get_contents(Path::get('/app/wp-config.php.template'));
        $config['keys'] = static::getKeys();

        foreach ($config as $group) {

            foreach ($group as $var => $value) {
                $template = str_replace('{{ ' . $var . ' }}', $value, $template);
            }
        }

        return file_put_contents(Path::get("/app/sites/{$domain}.php"), $template);
    }

    public static function getSites()
    {
        $sites = array();

        foreach (scandir(Path::get('/app/sites')) as $file) {

            if (preg_match('/^(.*)\.php$/', $file, $match) === 1) {
                $sites[] = $match[1];
            }
        }

        return $sites;
    }
}
