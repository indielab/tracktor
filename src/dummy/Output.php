<?php

namespace indielab\tracktor\dummy;

use indielab\tracktor\base\BaseOutputParser;

/**
 *
 * Example proble buffer:
 *
 * ```php
 * 19:12:31.719657 1.0 Mb/s 2412 MHz 11b -59dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:a0:2c:36:26:30:45 (oui Unknown) Probe Request () [1.0* 2.0* 5.5* 11.0* 6.0* 9.0 12.0* 18.0 Mbit]
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Output extends BaseOutputParser
{
    public function getSignal()
    {
        return $this->getSegmentSignal();
    }

    public function getSSID()
    {
        return $this->getSegmentSSID();
    }

    public function getMac()
    {
        return $this->getSegmentMac();
    }
}
