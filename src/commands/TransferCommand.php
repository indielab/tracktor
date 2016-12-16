<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use indielab\tracktor\readers\TcpdumpReader;
use indielab\tracktor\tracker\BufferOutput;
use Curl\Curl;

class TransferCommand extends Command
{
    private $machine;
    private $api;
    
    protected function configure()
    {
        $this->setName('transfer')
            ->addArgument('device', InputArgument::REQUIRED, 'rcpdump device name')
            ->addArgument('api', InputArgument::REQUIRED, 'The api endpoint to transfer data')
            ->addArgument('machine', InputArgument::REQUIRED, 'machine identifier for the api');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $input->getArguments();
        
        $this->machine = $args['machine'];
        $this->api = $args['api'];
        
        $reader = new TcpdumpReader($args['device'], 30, [$this, 'transmit']);
        $reader->run();
    }
    
    public function transmit($data)
    {
        foreach ($data as $provider) {
            $buff = new BufferOutput($provider);
            $curl = new Curl();
            $curl->post($this->api, [
                'machine' => $this->machine,
                'mac' => $buff->getMac(),
                'signal' => $buff->getSignal(),
                'timestamp' => $buff->getTime(),
                'ssid' => $buff->getSSID(),
            ]);
        }
    }
}
