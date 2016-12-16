<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tracker\DataProviderInterface;
use indielab\tracktor\tracker\BufferOutput;

class StubDataProvider implements DataProviderInterface
{
    private $signal = null;
    private $mac = null;
    private $names = null;
    
    public function __construct($signal = null, $mac = null, $names = null)
    {
        $this->signal = $signal;
        $this->mac = $mac;
        $this->names = $names;
    }
    
    public function getNames()
    {
        return $this->names;
    }
    
    public function getMac()
    {
        return $this->mac;
    }
    
    public function getSignal()
    {
        return $this->signal;
    }
}

class SegmentBufferOutputTest extends TracktorTestCase
{
    public $compareMac = [
        '12:12:12' => '12:12:12',
        'SA:12:12' => '12:12',
    ];
    
    public $compareSignal = [
        '-1' => '-1',
        '-1 Signal' => '-1',
        '-1 Foobar' => '-1',
        '-1' => '-1',
        '-123' => '-123',
        '-123 Signal' => '-123',
    ];
    
    public function testCompareMac()
    {
        foreach ($this->compareMac as $input => $match) {
            $provider = new StubDataProvider(null, $input, null);
            $output = new BufferOutput($provider);
            $this->assertSame($match, $output->getMac());
        }
    }
    
    public function testCompareSignal()
    {
        foreach ($this->compareSignal as $input => $match) {
            $provider = new StubDataProvider($input, null, null);
            $output = new BufferOutput($provider);
            $this->assertSame($match, $output->getSignal());
        }
    }
}