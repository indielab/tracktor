<?php

namespace indielab\tracktor\tracker;

/**
 * https://regex101.com/r/gPh0tS/1
 *
 * @author Basil Suter <basil@nadar.io>
 */
class BufferParser implements DataProviderInterface
{
    const REGEX = '/(?<signal>[\-0-9dB]+\ssignal)|(?<mac>SA\:[a-z0-9\:]+)|(?<names>\(([\_\-0-9a-zA-Z\s]+)\))/mi';
    
    const KEY_SIGNAL = 'signal';
    
    const KEY_MAC = 'mac';
    
    const KEY_NAMES = 'names';
    
    private $_buffer = null;
    
    private $_isValid = false;
    
    private $_segments = [];
    
    public function __construct($buffer)
    {
        $this->_buffer = trim($buffer);
        $this->parse();
    }
    
    private function parse()
    {
        if (strpos($this->getBuffer(), 'You don\'t have permission to capture on that device')) {
            throw new \Exception("Unable to read from the network device, you have to run the script as ROOT.");
        }
            
        $preg = preg_match_all(self::REGEX, $this->getBuffer(), $results);
        
        $signal = $this->findSegment(self::KEY_SIGNAL, $results);
        $mac = $this->findSegment(self::KEY_MAC, $results);
        $names = $this->findSegment(self::KEY_NAMES, $results);
        
        if (!$signal || !$mac) {
            return false;
        }
        
        $this->_segments = [
            self::KEY_MAC => $mac,
            self::KEY_SIGNAL => $signal,
            self::KEY_NAMES => $names,
        ];
        
        $this->_isValid = true;
    }
    
    private function getSegment($name, $default= false)
    {
        return (isset($this->_segments[$name])) ? $this->_segments[$name] : $default;
    }
    
    private function findSegment($key, $results)
    {
        if (isset($results[$key]) && !empty($results[$key])) {
            return array_filter($results[$key]);
        }
        
        return false;
    }
    
    private function toString($value)
    {
        if (is_array($value)) {
            return array_values($value)[0];
        }
        
        return $value;
    }
    
    public function getBuffer()
    {
        return $this->_buffer;
    }
    
    public function isValid()
    {
        return $this->_isValid;
    }
    
    public function getNames()
    {
        return $this->getSegment(self::KEY_NAMES, []);
    }
    
    public function getMac()
    {
        return $this->toString($this->getSegment(self::KEY_MAC));
    }
    
    public function getSignal()
    {
        return $this->toString($this->getSegment(self::KEY_SIGNAL));
    }
}
