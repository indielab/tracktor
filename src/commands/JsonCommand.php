<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use indielab\tracktor\base\BaseCommand;
use indielab\tracktor\base\OutputIterator;

/**
 * Generate a json encoded output based for a wlan device.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class JsonCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('json')
        ->addArgument('device', InputArgument::REQUIRED, 'The device name to lookup with the tcpdump command. In order to find the device name run the `ifconfig` command.')
        ->setDescription('Generate a json encoded output based for a wlan device.')
        ->setHelp('sudo php tracktor.php json <DEVICE_NAME>');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputDevice = $input->getArgument('device');
         
        $reader = $this->createReaderObject($inputDevice, 10, function (OutputIterator $data) use ($output) {
            $return = [];
            foreach ($data as $item) {
                /* @var $item \indielab\tracktor\base\OutputItemInterface */
                $return[] = ["macId" => $item->getMac(), "db" => $item->getSignal(), "ssid" => $item->getSSID(), "time" => date("H:i:s")];
            }

            echo json_encode($return) . "\n";
        });

        $reader->run();
    }
}
