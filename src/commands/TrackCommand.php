<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TrackCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:tracker')
            ->addArgument('device', InputArgument::REQUIRED, 'The ifconfig device name')
            ->setDescription('Tracking Data based on Input device')
            ->setHelp('app:tracker fwh01');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $device = $input->getArgument('device');
        
        $output->writeln([
            'Device',
            '=======',
            'Input: ' . $device, 
        ]);
        
        $request = "type mgt subtype probe-req";
        
        $handle = popen("sudo tcpdump -I -e -i {$device} -s 256 {$request} -l 2>&1", 'r');
        
        while (!feof($handle)) {
            
            $buffer = fgets($handle);
            
        }
        
        
    }
}