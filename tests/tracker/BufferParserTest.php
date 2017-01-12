<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tracker\BufferParser;

class BufferParserTest extends TracktorTestCase
{
    public function testInvalidInputException()
    {
        $this->expectException('Exception');
        $parser = new BufferParser('tcpdump: wlx7cdd90a9adbb: You don\'t have permission to capture on that device');
    }
}