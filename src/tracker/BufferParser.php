<?php

namespace indielab\tracktor\tracker;

/**
 * https://regex101.com/r/gPh0tS/1
 * 
 * @author nadar
 */
class BufferParser
{
    private $_buffer = null;
    
    public function __construct($buffer)
    {
        $this->_buffer = trim($buffer);
    }
    
    public function getBuffer()
    {
        return $this->_buffer;
    }
    
    public function isValid()
    {
        return is_numeric(substr($this->getBuffer(), 0, 1));
    }
    
    public function getSegments()
    {
        $preg = preg_match_all('/'.self::getRegex().'/mi', $this->getBuffer(), $results, PREG_OFFSET_CAPTURE);
        
        return $results;
    }
    
    private static function getRegex()
    {
        return '(?<signal>[\-0-9dB]+\ssignal)|(?<mac>SA\:[a-z0-9\:]+)|(?<names>\(([\_\-0-9a-zA-Z\s]+)\))';
    }
}