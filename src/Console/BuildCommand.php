<?php

namespace TCB\Console;

use TCB\Model\Site;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BuildCommand extends Command
{
    const PROMPT_LIMIT = 10;

    protected $domain = '';
    protected $config = array();



    protected function promptDomain(OutputInterface $output)
    {
        for ($i = 0;$i < static::PROMPT_LIMIT;$i++) {
            $output->writeln('');

            // Get site code.
            $this->domain = $this->ask($output, 'Site\'s domain name?', false,
                function ($answer) {
                    $answer = trim($answer);
                    $answer = str_replace('/', '', $answer);
                    $answer = str_replace(array('http:', 'https:'), '', $answer);

                    if (!Site::isValidDomain($answer)) {
                        throw new \RuntimeException('You Need to enter a domain.');
                    }

                    return $answer;
                });

            if ($this->askYesNo($output, 'Is this correct?', true)) {
                break;
            }
        }
    }

    protected function promptDatabase(OutputInterface $output)
    {
        for ($i = 0;$i < static::PROMPT_LIMIT;$i++) {
            $output->writeln('');

            // Get database vars from User.
            $this->config['db'] = array(
                'DB_NAME'       => $this->ask($output, 'Database name?'),
                'DB_USER'       => $this->ask($output, 'Database username?'),
                'DB_PASSWORD'   => $this->ask($output, 'Database password?'),
                'DB_HOST'       => $this->ask($output, 'Database host? Default is localhost. Just hit enter if in doubt.', 'localhost'),
                'DB_CHARSET'    => $this->ask($output, 'Database charset? Default is utf8. Just hit enter if in doubt.', 'utf8'),
                'DB_COLLATE'    => $this->ask($output, 'Database collate? Default is blank, Just hit enter if in doubt.', ''),
            );

            $this->writeTable($output, $this->config['db'], 'Database');

            if ($this->askYesNo($output, 'Are these settings correct?', true)) {
                break;
            }
        }
    }

    protected function promptOther(OutputInterface $output)
    {
        for ($i = 0;$i < static::PROMPT_LIMIT;$i++) {
            $output->writeln('');

            // Get other vars from the User.
            $this->config['other'] = array(
                'TABLE_PREFIX'  => $this->ask($output, 'Table prefix? Default is "wp_".', 'wp_'),
                'WP_DEBUG'      => (($this->askYesNo($output, 'Use debug mode? Default is false.', false)) ? 'true' : 'false')
            );

            $this->writeTable($output, $this->config['other'], 'Other');

            if ($this->askYesNo($output, 'Are these settings correct?', true)) {
                break;
            }
        }
    }
}
