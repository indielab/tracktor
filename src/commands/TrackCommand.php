<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use indielab\tracktor\tracker\BufferParser;
use indielab\tracktor\tracker\BufferOutput;
use Symfony\Component\Console\Helper\Table;

class TrackCommand extends Command
{
    protected function configure()
    {
        $this->setName('track')
            ->addArgument('device', InputArgument::REQUIRED, 'The ifconfig device name')
            ->setDescription('Tracking Data based on Input device')
            ->setHelp('app:tracker fwh01');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $device = $input->getArgument('device');
     
        $output->writeln([
            'Device',
            '======',
            'Input: ' . $device,
        ]);
        
        $handle = popen("tcpdump -I -e -i {$device} -s 256 type mgt subtype probe-req -l 2>&1", 'r');
        
        $table = new Table($output);
        
        $table->setheaders(['mac', 'signal', 'ssid']);
        while (!feof($handle)) {
            $provider = new BufferParser(fgets($handle));
            if ($provider->isValid()) {
                $output = new BufferOutput($provider);
                
                $table->setRows([
                    [$output->getMac(), $output->getSignal(), $output->getSSID()]
                ]);
                
                $table->render();
            }
        }
        
        pclose($handle);
    }
}
