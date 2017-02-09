<?php

namespace indielab\tracktor\tests\commands;

use indielab\tracktor\tests\TracktorTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use indielab\tracktor\commands\TransferCommand;

class TransferCommandTest extends TracktorTestCase
{
    public function testTrackCommand()
    {
        $app = new Application();
        $app->add(new TransferCommand());
        $command = $app->find('transfer');
        $command->readerClass = 'indielab\tracktor\dummy\Reader';
        $commandTester = new CommandTester($command);
        
        $this->expectException('\indielab\tracktor\ExitException');
        $commandTester->execute([
            'command' => $command->getName(),
            'device' => 'fw0',
            'api' => 'none',
            'machine' => 'none',
        ]);
    }
}
