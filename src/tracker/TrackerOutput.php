<?php

namespace indielab\tracktor\tracker;

/**
 * 
 * Example proble buffer:
 * 
 * ```php
 * 19:12:31.719657 1.0 Mb/s 2412 MHz 11b -59dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:a0:2c:36:26:30:45 (oui Unknown) Probe Request () [1.0* 2.0* 5.5* 11.0* 6.0* 9.0 12.0* 18.0 Mbit]
 * ```
 * @author nadar
 */
class TrackerOutput
{
    private $_buffer = null;
    
    public function __construct($buffer)
    {
        $this->_buffer = $buffer;        
    }
    
    public function getSignal()
    {
        
    }
    
    public function getNoise()
    {
        
    }
    
    public function getSignal()
    {
        
    }
    
    public function getMac()
    {
        
    }
}