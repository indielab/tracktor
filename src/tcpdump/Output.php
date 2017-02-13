<?php

namespace indielab\tracktor\tcpdump;

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
        $value = $this->getSegmentSignal();

        if (preg_match('/\-[0-9]+/i', $value, $results)) {
            return $results[0];
        }

        return null;
    }

    public function getSSID()
    {
        return $this->getSegmentSSID();
    }

    public function getMac()
    {
        $value = $this->getSegmentMac();

        $prefix = substr($value, 0, 3);

        if ($prefix == 'SA:') {
            return md5(substr_replace($value, '', 0, 3));
        }

        return md5($value);
    }
}
