<?php

namespace indielab\tracktor\readers;

use indielab\tracktor\tracker\BufferParser;

/**
 * Rcpdump Reader
 *
 * ```php
 * $reader = new TcpdumpReader('device', 30, function($data) {
 *     // this will be executed each 30 seconds:
 *     var_dump($data);
 * });
 * $reader->run();
 * ```
 *
 * In order to run a method inside the current object you can configure the callback as followed:
 *
 * ```php
 * $reader = new TcdpdumpReader('device', 30, [$this, 'theMethod']);
 * $reader->run();
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TcpdumpReader implements ReaderInterface
{
    private $_device;
    
    private $_waitTimer;
    
    private $_callback;
    
    public function __construct($device, $waitTimer, $callback)
    {
        $this->_device = $device;
        $this->_waitTimer = $waitTimer;
        $this->_callback = $callback;
    }
    
    public function run()
    {
        $handle = popen("tcpdump -I -e -i {$this->_device} -s 256 type mgt subtype probe-req -l 2>&1", 'r');
        $stamp = time();
        $collectors = [];
        while (!feof($handle)) {
            if ((time() - $stamp) > $this->_waitTimer) {
                $stamp = time();
                $this->runCallback($collectors);
                $collectors = [];
            }
        
            $provider = new BufferParser(fgets($handle));
            if ($provider->isValid()) {
                $collectors[] = $provider;
            }
        }
        
        pclose($handle);
    }
    
    protected function runCallback($data)
    {
        if (is_callable($this->_callback)) {
            return call_user_func($this->_callback, $data);
        }
        
        if (is_array($this->_callback)) {
            return call_user_func_array($this->_callback, [$data]);
        }
    }
}
