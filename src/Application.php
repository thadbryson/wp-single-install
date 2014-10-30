<?php

namespace TCB;

use TCB\Model\Path;

use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('WP Single Code', '0.1-alpha');
    }

    public function getWpDir()
    {
        $settings = Path::get('/app/settings.json');

        if (!file_exists($settings)) {
            file_put_contents($settings, json_encode(array('wordpress_dir' => '')));
        }

        $settings = file_get_contents($settings);
        $settings = json_decode($settings, true);

        if ($settings['wordpress_dir'] === null) {
            throw new \Exception('/app/settings.json not setup correctly. Needs wordpress_dir configuration.');
        }

        return $settings['wordpress_dir'];
    }
}