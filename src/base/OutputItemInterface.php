<?php

namespace indielab\tracktor\base;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface OutputItemInterface
{
    public function __construct($buffer);
    
    public function getSSID();
    
    public function getMac();
    
    public function getSignal();
    
    public function isValid();
}
