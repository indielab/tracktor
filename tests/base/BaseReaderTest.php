<?php

namespace indielab\tracktor\tests\base;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\dummy\Reader;

class BaseReaderTest extends TracktorTestCase
{
    public function testLambdaCallback()
    {
        $reader = new Reader(' device', 60, function($data) { 
            return $data;
        });
        $this->assertInstanceOf('indielab\tracktor\base\OutputIterator', $reader->run());
        $this->assertSame('device', $reader->getDevice());
        $this->assertSame(60, $reader->getWaitTimer());
    }
    
    public function testArrayCallback()
    {
        $reader = new Reader('device  ', 60, [$this, 'arrayCallback']);
        $this->assertInstanceOf('indielab\tracktor\base\OutputIterator', $reader->run());
        $this->assertSame('device', $reader->getDevice());
        $this->assertSame(60, $reader->getWaitTimer());
        
        $this->assertTrue(is_array($reader->getCallback()));
        $this->assertTrue(is_callable($reader->getCallback()));
        $this->assertTrue(is_callable($reader->getCallback(), true));
    }
    
    // callback for `testArrayCallback` method.
    public function arrayCallback($data)
    {
        return $data;
    }
    
    public function testInvalidCallback()
    {
        $reader = new Reader('device  ', 60, 'notCallable');
        $this->expectException('\indielab\tracktor\ExitException');
        $reader->run();
    }
}
