<?php

namespace indielab\tracktor\tracker;

interface DataProviderInterface
{
    public function getNames();
    
    public function getMac();
    
    public function getSignal();
}
