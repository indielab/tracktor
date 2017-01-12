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
    private $machineId;
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
        
        $this->api = $args['api'];
        
        $config = $this->getConfig($this->api, $args['machine']);
        $this->machineId = $config['id'];
        
        $reader = new TcpdumpReader($args['device'], $config['wait_timer'], [$this, 'transmit']);
        $reader->run();
    }
    
    public function getConfig($api, $machineId)
    {
        $curl = new Curl();
        $curl->get(rtrim($api, '/') . '/config', ['machineId' => $machineId]);
        
        if ($curl->error) {
            throw new \Exception("Unable to find config for the machine " . $machineId);
        }
        
        $json = json_decode($curl->response, true);
        
        if (json_last_error() == JSON_ERROR_NONE) {
            return $json;
        }
        
        throw new \Exception("Unable to decode API Response: " . $curl->response);
    }
    
    public function transmit($data)
    {
        foreach ($data as $provider) {
            $buff = new BufferOutput($provider);
            $curl = new Curl();
            $curl->post($this->api, [
                'machine_id' => $this->machineId,
                'mac' => $buff->getMac(),
                'signal' => $buff->getSignal(),
                'timestamp' => $buff->getTime(),
                'ssid' => $buff->getSSID(),
            ]);
        }
    }
}
