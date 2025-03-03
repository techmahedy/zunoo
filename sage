#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$console = new Application();
$console->setCatchExceptions(true);

$commandsDir = __DIR__ . '/vendor/zuno/zuno/src/zuno/Console/Commands';
$commandFiles = glob($commandsDir . '/*.php');

foreach ($commandFiles as $commandFile) {
    require_once $commandFile;
    $className = 'Zuno\Console\Commands\\' . basename($commandFile, '.php');
    $command = new $className();
    $console->add($command);
}

$status = $console->run();

exit($status);
