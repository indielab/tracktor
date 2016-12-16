<?php

namespace indielab\tracktor\tracker;

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
class BufferOutput
{
    private $_provider = null;
    
    public function __construct(DataProviderInterface $provider)
    {
        $this->_provider = $provider;
    }
    
    public function getProvider()
    {
        return $this->_provider;
    }
    
    public function getSignal()
    {
        $value = $this->getProvider()->getSignal();
        
        if (preg_match('/\-[0-9]+/i', $value, $results)) {
            return $results[0];
        }
        
        return false;
    }
    
    public function getSSID()
    {
        $array = $this->getProvider()->getNames();
        $item = end($array);
        
        if (preg_match('/\((.*)\)/i', $item, $results)) {
            return $results[1];
        }
        
        return $item;
    }
    
    public function getMac()
    {
        $value = $this->getProvider()->getMac();
        
        $prefix = substr($value, 0, 3);
        
        if ($prefix == 'SA:') {
            return substr_replace($value, '', 0, 3);
        }
        
        return $value;
    }
    
    public function getTime()
    {
        return time();
    }
}
