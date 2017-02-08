<?php

namespace indielab\tracktor\base;

class OutputIterator implements \Iterator
{
    private $_array = [];
    
    public function __construct(array $array)
    {
        $this->_array = $array;
    }
    
    public function rewind()
    {
        return reset($this->_array);
    }
    
    /**
     * @return \indielab\tracktor\base\OutputItemInterface
     */
    public function current()
    {
        return current($this->_array);
    }
    
    public function key()
    {
        return key($this->_array);
    }
    
    public function next()
    {
        return next($this->_array);
    }
    
    public function valid()
    {
        return key($this->_array) !== null;
    }
}
