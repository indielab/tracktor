<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;
use indielab\tracktor\tracker\BufferOutput;
use indielab\tracktor\readers\TcpdumpReader;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TrackCommand extends Command
{
    protected function configure()
    {
        $this->setName('track')
            ->addArgument('device', InputArgument::REQUIRED, 'The name of the device to listen.')
            ->setDescription('Tracking Data based on Input device')
            ->setHelp('app:tracker fwh01');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $device = $input->getArgument('device');
     
        $reader = new TcpdumpReader($device, 10, function ($data) use ($output) {
            $tables = [];
            foreach ($data as $provider) {
                $buff = new BufferOutput($provider);
                $tables[] = [$buff->getMac(), $buff->getSignal(), $buff->getSSID(), date("H:i:s")];
            }
            
            $table = new Table($output);
            $table->setheaders(['Mac', 'Signal', 'SSID', 'Time']);
            $table->setRows($tables);
            $table->render();
        });
        
        $reader->run();
    }
}
