<?php

namespace indielab\tracktor\tests\commands;

use indielab\tracktor\tests\TracktorTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use indielab\tracktor\commands\JsonCommand;

class JsonCommandTest extends TracktorTestCase
{
    public function testTrackCommand()
    {
        $app = new Application();
        $app->add(new JsonCommand());
        $command = $app->find('json');
        $command->readerClass = 'indielab\tracktor\dummy\Reader';
        $commandTester = new CommandTester($command);
        
        ob_start();
        $commandTester->execute([
            'command' => $command->getName(),
            'device' => 'fw0',
        ]);
        $commandTester->getDisplay();
        $out = ob_get_contents();
        ob_end_clean();
        
        $this->assertContains('"macId":"SA:0c:74:c2:27:4d:3c","db":"-63dB signal","ssid":"oui Unknown"', $out);
    }
}
