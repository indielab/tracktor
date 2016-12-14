<?php

use Symfony\Component\Console\Application;
use indielab\tracktor\commands\TrackCommand;

require __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->add(new TrackCommand());
$app->run();