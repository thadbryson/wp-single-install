<?php

namespace TCB\Console;

use TCB\Model\Site;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleBuild extends BuildCommand
{
    protected $title = 'Add a new Site';



    protected function configure()
    {
        $this
            ->setName('example:build')
            ->setDescription('Build a bunch of example configs all at once.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->header($output);

        $this->promptDomain($output);
        $this->promptDatabase($output);
        $this->promptOther($output);

        $numberSites = $this->ask($output, 'How many sites?', false,
            function ($answer) {

                if (!is_numeric($answer)) {
                    throw new \RuntimeException($answer . ' is not a number.');
                }

                return $answer;
            });

        $this->subheader($output, "Building {$numberSites} site configs...");

        for ($i = 1;$i <= $numberSites;$i++) {
            $config                   = $this->config;
            $config['db']['DB_NAME'] .= '_'.$i;

            $domain = "wp{$i}." . $this->domain;

            Site::build($config, $domain);
        }

        $output->writeln('Done');

        $this->footer($output);
    }
}
