<?php

use Symfony\Component\Console\Application;
use indielab\tracktor\commands\TransferCommand;
use indielab\tracktor\commands\ListCommand;
use indielab\tracktor\commands\JsonCommand;

require __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->add(new ListCommand());
$app->add(new TransferCommand());
$app->add(new JsonCommand());
$app->run();
