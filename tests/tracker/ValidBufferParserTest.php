<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tracker\BufferParser;
use indielab\tracktor\tracker\BufferOutput;
class ValidBufferParserTest extends TracktorTestCase
{
    public $tests = [
        [
            'buffer' => '16:56:31.948018 1.0 Mb/s 2412 MHz 11b -63dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:0c:74:c2:27:4d:3c (oui Unknown) Probe Request () [1.0 2.0 5.5 11.0 Mbit]',
            'signal' => '-63',
            'mac' => '0c:74:c2:27:4d:3c',
            'name' => 'oui Unknown'
        ]
    ];
    
    public function testWithBuffers()
    {
        foreach ($this->tests as $test) {
            $parser = new BufferParser($test['buffer']);
            $output = new BufferOutput($parser);
            $this->assertSame($test['signal'], $output->getSignal());
            $this->assertSame($test['mac'], $output->getMac());
            $this->assertSame($test['name'], $output->getSID());
        }
    }
}