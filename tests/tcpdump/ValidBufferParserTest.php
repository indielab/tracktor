<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tcpdump\Output;

class ValidBufferParserTest extends TracktorTestCase
{
    public $tests = [
        [
            'buffer' => '16:56:31.948018 1.0 Mb/s 2412 MHz 11b -63dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:0c:74:c2:27:4d:3c (oui Unknown) Probe Request () [1.0 2.0 5.5 11.0 Mbit]',
            'signal' => '-63',
            'mac' => '0c:74:c2:27:4d:3c',
            'ssid' => 'oui Unknown',
            'valid' => true,
        ], [
            'buffer' => '17:33:37.426882 1.0 Mb/s 2412 MHz 11b -69dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:24:1f:a0:5d:77:c2 (oui Unknown) Probe Request (Swisscom_Auto_Login) [1.0* 2.0* 5.5* 11.0* 6.0* 9.0* 12.0* 18.0* Mbit]',
            'signal' => '-69',
            'mac' => '24:1f:a0:5d:77:c2',
            'ssid' => 'Swisscom_Auto_Login',
            'valid' => true,
        ], [
            'buffer' => 'none',
            'signal' => null,
            'mac' => null,
            'ssid' => null,
            'valid' => false,
        ]
    ];
    
    public function testWithBuffers()
    {
        foreach ($this->tests as $test) {
            $output = new Output($test['buffer']);
            $this->assertSame($test['signal'], $output->getSignal());
            $this->assertSame($test['mac'], $output->getMac());
            $this->assertSame($test['ssid'], $output->getSSID());
            $this->assertSame($test['valid'], $output->isValid());
        }
    }
}
