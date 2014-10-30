<?php

namespace TCB\Console;

use TCB\Application as App;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

abstract class Command extends BaseCommand
{
    protected $title = '';



    protected function header(OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('-----' . $this->title . '-----');
        $output->writeln('');
    }

    protected function subheader(OutputInterface $output, $subheader)
    {
        $output->writeln($subheader);
        $output->writeln('');
    }

    protected function footer(OutputInterface $output)
    {
        $output->writeln('');
    }

    protected function green(OutputInterface $output, $line)
    {
        $output->writeln('<info>'.$line.'</info>');
    }

    protected function writeTable(OutputInterface $output, array $rows, $title)
    {
        $output->writeln('');
        $this->green($output, $title);
        $output->writeln('');

        $rowOutput = array();

        foreach ($rows as $config => $value) {
            $rowOutput[] = array($config, $value);
        }

        $table = new Table($output);
        $table
            ->setHeaders(array('Config', 'Value'))
            ->setRows($rowOutput)
            ->render()
        ;
    }

    protected function ask(OutputInterface $output, $question, $default = false, $callback = false)
    {
        $dialog = $this->getHelper('dialog');

        if ($callback === false) {
            $callback = function ($answer) {
                if ($default === false && strlen($answer) <= 0) {
                    throw new \RuntimeException("You must answer.\n");
                }

                return $answer;
            };
        }

        // Ask and validate. Add a space at the end of the question.
        $answer = $dialog->askAndValidate($output, trim($question).' ', $callback, false, $default);

        $output->writeln('Answer: <info>' . $answer . '</info>');
        $output->writeln('');

        return $answer;
    }

    protected function askYesNo(OutputInterface $output, $question, $default = false)
    {
        $dialog = $this->getHelper('dialog');

        $boolean = array('Yes', 'No');
        $default = ($default) ? 0 : 1;

        $output->writeln('');

        $answer = $boolean[ $dialog->select($output, $question, $boolean, $default) ];

        return ($answer === 'Yes');
    }
}
