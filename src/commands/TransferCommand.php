<?php

namespace indielab\tracktor\commands;

use Curl\Curl;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use indielab\tracktor\base\BaseCommand;
use indielab\tracktor\base\OutputIterator;
use indielab\tracktor\ExitException;

/**
 * Send collected data based on a wifi device to a Rest API.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TransferCommand extends BaseCommand
{
    private $machineId;
    private $api;
    
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('transfer')
        ->addArgument('device', InputArgument::REQUIRED, 'The device name to lookup with the tcpdump command. In order to find the device name run the `ifconfig` command.')
        ->addArgument('api', InputArgument::REQUIRED, 'The api endpoint to transfer data')
        ->addArgument('machine', InputArgument::REQUIRED, 'machine identifier for the api')
        ->setDescription('Send collected data based on a wifi device to a Rest API.')
        ->setHelp('sudo php tracktor.php transfer <DEVICE_NAME> <API_URL> <MACHINE_NAME>');
    }
    
    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $input->getArguments();
        
        $this->api = $args['api'];
        
        $config = $this->getConfig($this->api, $args['machine']);
        $this->configId = $config['id'];
        
        $reader = $this->createReaderObject($args['device'], $config['wait_timer'], [$this, 'transmit']);
        $reader->run();
    }
    
    public function getConfig($api, $machineId)
    {
        $curl = new Curl();
        $curl->get(rtrim($api, '/') . '/config', ['machineId' => $machineId]);
        
        if ($curl->error) {
            throw new ExitException("Unable to find config for the machine " . $machineId);
        }
        
        $json = json_decode($curl->response, true);
        
        if (json_last_error() == JSON_ERROR_NONE) {
            unset($curl);
            return $json;
        }
        
        throw new ExitException("Unable to decode API Response: " . $curl->response);
    }
    
    public function transmit(OutputIterator $data)
    {
        foreach ($data as $item) {
            /* @var $item \indielab\tracktor\base\OutputItemInterface */
            $curl = new Curl();
            $curl->post($this->api, [
                'config_id' => $this->configId,
                'mac' => $item->getMac(),
                'signal' => $item->getSignal(),
                'timestamp' => time(),
                'ssid' => $item->getSSID(),
            ]);
            unset($curl);
        }
        
        unset($data);
    }
}
