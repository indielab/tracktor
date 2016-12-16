<?php

namespace indielab\tracktor\tests\commands;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\commands\TrackCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;

class TrackCommandTest extends TracktorTestCase
{
    public function testTrackCommand()
    {
        $app = new Application();
        $app->add(new TrackCommand());
        $command = $app->find('track');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'device' => 'fw0',
        ]);
        
        
        $this->assertEmpty($commandTester->getDisplay());
    }
}
