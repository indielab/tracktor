<?php

namespace indielab\tracktor\base;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface ReaderInterface
{
    public function __construct($device, $waitTimer, $callback);
    
    public function run();
}
