<?php

namespace indielab\tracktor\tracker;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 */
interface DataProviderInterface
{
    public function getNames();
    
    public function getMac();
    
    public function getSignal();
}
