<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tracker\BufferParser;

class ValidityBufferParserTest extends TracktorTestCase
{
    private $validPatterns = [
        '16:56:31.948018 1.0 Mb/s 2412 MHz 11b -63dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:0c:74:c2:27:4d:3c (oui Unknown) Probe Request () [1.0 2.0 5.5 11.0 Mbit]',
        '17:33:37.426882 1.0 Mb/s 2412 MHz 11b -69dB signal antenna 1 BSSID:Broadcast DA:Broadcast SA:24:1f:a0:5d:77:c2 (oui Unknown) Probe Request (Swisscom_Auto_Login) [1.0* 2.0* 5.5* 11.0* 6.0* 9.0* 12.0* 18.0* Mbit]',
    ];
    
    private $invalidPatterns = [
        'abc',
    ];
    
    public function testValidPatterns()
    {
        foreach ($this->validPatterns as $buffer) {
            $parser = new BufferParser($buffer);
            $this->assertTrue($parser->isValid());
        }
    }

    public function testInvalidPatterns()
    {
        foreach ($this->invalidPatterns as $buffer) {
            $parser = new BufferParser($buffer);
            $this->assertFalse($parser->isValid());
        }
    }
}
