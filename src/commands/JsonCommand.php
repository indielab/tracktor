<?php

namespace indielab\tracktor\commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
//use Symfony\Component\Console\Helper\Table;
use indielab\tracktor\tracker\BufferOutput;
use indielab\tracktor\readers\TcpdumpReader;

class JsonCommand extends Command
{
	protected function configure()
	{
		$this->setName('json')
		->addArgument('input', InputArgument::REQUIRED, 'The name of the input to listen.')
		->setDescription('Tracking Data based on Input device')
		->setHelp('app:tracker fwh01');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$inputDevice = $input->getArgument('input');
		 
		$reader = new TcpdumpReader($inputDevice, 10, function ($data) use ($output) {
			
			$return = [];
			foreach ($data as $provider) {
				$buff = new BufferOutput($provider);
				$return[] = ["macId" => $buff->getMac(), "db" => $buff->getSignal(), "ssid" => $buff->getSSID(), "time" => date("H:i:s")];
			}

			echo json_encode($return) . "\n";
			
		});

		$reader->run();
		
	}
}
