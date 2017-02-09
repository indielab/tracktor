<?php

namespace indielab\tracktor\tests\tracker;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\tcpdump\Output;

class OutputTest extends TracktorTestCase
{
    public function testInvalidInputException()
    {
        $this->expectException('indielab\tracktor\ExitException');
        $parser = new Output('tcpdump: sthelse: You don\'t have permission to capture on that device');
    }
    
    public function testInvalidInputExceptionDev()
    {
        $this->expectException('indielab\tracktor\ExitException');
        $parser = new Output('tcpdump: wlx7cdd90a9adbb: You don\'t have permission to capture on that device');
    }
    
    public function testInvalidInputExceptionMin()
    {
        $this->expectException('indielab\tracktor\ExitException');
        $parser = new Output('FOOBAR You don\'t have permission to capture on that device. NOT BAR FOO');
    }
    
    
    public function testOutputParserInit()
    {
        $parser = new Output('test');
        $this->assertNull($parser->getSSID());
    }
}
