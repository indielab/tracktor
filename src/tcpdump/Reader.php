<?php

namespace indielab\tracktor\tcpdump;

use indielab\tracktor\base\OutputIterator;
use indielab\tracktor\base\BaseReader;
use indielab\tracktor\ExitException;

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
class Reader extends BaseReader
{
    public function run()
    {
        $handle = popen("tcpdump -I -e -i {$this->getDevice()} -s 256 type mgt subtype probe-req -l 2>&1", 'r');
        
        if (!$handle) {
            throw new ExitException("Popen Handler returns false when run tcpdump command on {$this->getDevice()}.");
        }
            
        $stamp = time();
        $collectors = [];
        while (!feof($handle)) {
            if ((time() - $stamp) > $this->getWaitTimer()) {
                unset($stamp);
                $stamp = time();
                $this->runCallback(new OutputIterator($collectors));
                unset($collectors);
                $collectors = [];
            }
        
            $provider = new Output(fgets($handle));
            if ($provider->isValid()) {
                $collectors[] = $provider;
            }
            unset($provider);
            
            gc_collect_cycles();
        }
        
        pclose($handle);
        
        unset($stamp);
        unset($collectors);
        unset($provider);
        unset($handle);
        
        $this->run();
    }
}
