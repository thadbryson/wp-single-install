<?php

namespace TCB\Console;

use TCB\Application as App;
use TCB\Model\Path;
use TCB\Model\Wordpress;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ThemeList extends Command
{
    protected $title = 'Themes';



    protected function configure()
    {
        $this
            ->setName('theme:list')
            ->setDescription('List all themes you have installed.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->header($output);
        $this->subheader($output, 'Directory: ' . Path::get('wp-content/themes', true));

        foreach (Wordpress::getThemes() as $theme) {
            $this->green($output, $theme);
        }

        $this->footer($output);
    }
}
