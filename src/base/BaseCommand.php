<?php

namespace indielab\tracktor\base;

use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    public $readerClass = 'indielab\tracktor\tcpdump\Reader';
    
    public function createReaderObject($device, $waitTimer, $callback)
    {
        $class = $this->readerClass;

        return new $class($device, $waitTimer, $callback);
    }
}
