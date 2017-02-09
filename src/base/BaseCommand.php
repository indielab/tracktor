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
    
    /**
     *
     * @return string
     */
    public function getCurrentMemory()
    {
        return sprintf("%dKB", round(memory_get_usage() / 1024));
    }
    
    /**
     *
     * @return string
     */
    public function getMaxMemory()
    {
        return sprintf("%dKB", round(memory_get_peak_usage() / 1024));
    }
}
