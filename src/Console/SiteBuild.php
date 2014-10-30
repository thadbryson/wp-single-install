<?php

namespace TCB\Console;

use TCB\Model\Site;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteBuild extends BuildCommand
{
    protected $title = 'Add a new Site';



    protected function configure()
    {
        $this
            ->setName('site:build')
            ->setDescription('Build a wp-config.php file for another site.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->header($output);

        $this->promptDomain($output);
        $this->promptDatabase($output);
        $this->promptOther($output);

        $this->subheader($output, 'Building site config...');

        Site::build($this->config, $this->domain);

        $output->writeln('Done');

        $this->footer($output);
    }
}
