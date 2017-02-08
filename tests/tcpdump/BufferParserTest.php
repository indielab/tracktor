<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tcpdump\Output;

class BufferParserTest extends TracktorTestCase
{
    public function testInvalidInputException()
    {
        $this->expectException('Exception');
        $parser = new Output('tcpdump: sthelse: You don\'t have permission to capture on that device');
        
        $this->expectException('Exception');
        $parser = new Output('tcpdump: wlx7cdd90a9adbb: You don\'t have permission to capture on that device');
    }
}
