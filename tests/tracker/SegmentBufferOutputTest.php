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
    /**
     * @var array The KEY is the input, VALUE is the expected result
     */
    public $compareMac = [
        '12:12:12' => '12:12:12',
        'SA:12:12' => '12:12',
    ];
    
    /**
     * @var array The KEY is the input, VALUE is the expected result
     */
    public $compareSignal = [
        '-1' => '-1',
        '-1 Signal' => '-1',
        '-1 Foobar' => '-1',
        '-1' => '-1',
        '-123' => '-123',
        '-123 Signal' => '-123',
        '1' => false,
    ];

    /**
     * @var array The KEY is the expected result and the value array is the input. Inverted to signal and mac comperator!
     */
    public $compareSSID = [
        'SSID1' => ['SSID1'],
        'SSID2' => ['(SSID2)'],
        'BAR' => ['(FOO)', '(BAR)'],
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
    
    public function testCompareSSID()
    {
        foreach ($this->compareSSID as $match => $input) {
            $provider = new StubDataProvider(null, null, $input);
            $output = new BufferOutput($provider);
            $this->assertSame($match, $output->getSSID());
        }
    }
}
