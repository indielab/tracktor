<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\Table;
use indielab\tracktor\base\BaseCommand;
use indielab\tracktor\base\OutputIterator;

/**
 * List data from a device and output in table format.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ListCommand extends BaseCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('list')
        ->addArgument('device', InputArgument::REQUIRED, 'The device name to lookup with the tcpdump command. In order to find the device name run the `ifconfig` command.')
        ->setDescription('List data from a device and output in table format.')
        ->setHelp('sudo php tracktor.php list <DEVICE_NAME>');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputDevice = $input->getArgument('device');
     
        $output->writeln(['Current memory: ' . $this->getCurrentMemory(), 'Max memory:' . $this->getMaxMemory()]);
        
        $reader = $this->createReaderObject($inputDevice, 10, function (OutputIterator $data) use ($output) {
            $tables = [];
            foreach ($data as $item) {
                /* @var $item \indielab\tracktor\base\OutputItemInterface */
                $tables[] = [$item->getMac(), $item->getSignal(), $item->getSSID(), date("H:i:s"), $this->getCurrentMemory(), $this->getMaxMemory()];
            }
            $table = new Table($output);
            $table->setheaders(['Mac', 'Signal', 'SSID', 'Time', 'Memory current', 'Memory max']);
            $table->setRows($tables);
            $table->render();
            unset($table);
            unset($data);
        });

        $reader->run();
    }
    
    public function getCurrentMemory()
    {
        return sprintf("%dKB", round(memory_get_usage() / 1024));
    }
    
    public function getMaxMemory()
    {
        return sprintf("%dKB", round(memory_get_peak_usage() / 1024));
    }
}
