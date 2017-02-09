<?php

namespace indielab\tracktor\base;

use indielab\tracktor\base\ReaderInterface;
use indielab\tracktor\ExitException;

abstract class BaseReader implements ReaderInterface
{
    private $_device;
    
    private $_waitTimer;
    
    private $_callback;
    
    /**
     * Class constructor.
     *
     * @param string $device The device to listen with the tcpdump command.
     * @param string $waitTimer
     * @param callable|array $callback
     */
    public function __construct($device, $waitTimer, $callback)
    {
        $this->_device = trim($device);
        $this->_waitTimer = $waitTimer;
        $this->_callback = $callback;
    }
    
    public function getDevice()
    {
        return $this->_device;
    }
    
    public function getWaitTimer()
    {
        return $this->_waitTimer;
    }

    public function getCallback()
    {
        return $this->_callback;
    }
    
    /**
     * @param \indielab\tracktor\base\OutputIterator
     * @return void
     */
    protected function runCallback(OutputIterator $data)
    {
        if (is_callable($this->_callback)) {
            return call_user_func($this->_callback, $data);
        }
    
        throw new ExitException('Invalid callback paramter. Must be a callable function or an array with array object and method name.');
    }
}
