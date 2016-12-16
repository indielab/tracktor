<?php

namespace indielab\tracktor\tests\commands;

use indielab\tracktor\tests\TracktorTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use indielab\tracktor\commands\ListCommand;

class ListCommandTest extends TracktorTestCase
{
    public function testTrackCommand()
    {
        $app = new Application();
        $app->add(new ListCommand());
        $command = $app->find('list');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'input' => 'fw0',
        ]);
        
        
        $this->assertEmpty($commandTester->getDisplay());
    }
}
