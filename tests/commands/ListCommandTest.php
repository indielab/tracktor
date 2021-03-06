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
        $command->readerClass = 'indielab\tracktor\dummy\Reader';
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'device' => 'fw0',
        ]);
        
        $this->assertContains('-63dB signal', $commandTester->getDisplay());
        $this->assertContains('oui Unknown', $commandTester->getDisplay());
        $this->assertContains('SA:0c:74:c2:27:4d:3c', $commandTester->getDisplay());
    }
}
