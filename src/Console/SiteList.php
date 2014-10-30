<?php

namespace TCB\Console;

use TCB\Application as App;
use TCB\Model\Site;
use TCB\Model\Wordpress;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteList extends Command
{
    protected $title = 'Sites';



    protected function configure()
    {
        $this
            ->setName('site:list')
            ->setDescription('List all codes for sites you have installed.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->header($output);

        foreach (Site::getSites() as $site) {
            $this->green($output, $site);
        }

        $this->footer($output);
    }
}
