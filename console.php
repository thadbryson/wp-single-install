<?php

require __DIR__.'/vendor/autoload.php';

$application = new TCB\Application();

$application->add(new TCB\Console\ExampleBuild());
$application->add(new TCB\Console\SiteBuild());
$application->add(new TCB\Console\SiteList());
$application->add(new TCB\Console\ThemeList());

$shell = new Symfony\Component\Console\Shell($application);
$shell->run();
