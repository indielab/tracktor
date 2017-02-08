<?php

namespace indielab\tracktor\dummy;

use indielab\tracktor\base\OutputIterator;
use indielab\tracktor\base\BaseReader;

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
        $this->runCallback(new OutputIterator([new Output('16:56:31.948018 1.0 Mb/s 2412 MHz 11b -63dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:0c:74:c2:27:4d:3c (oui Unknown) Probe Request () [1.0 2.0 5.5 11.0 Mbit]')]));
    }
}
