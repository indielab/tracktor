<?php

namespace indielab\tracktor\tests\base;

use indielab\tracktor\tests\TracktorTestCase;
use indielab\tracktor\base\OutputIterator;
use indielab\tracktor\dummy\Output;

class OutputIteratorTest extends TracktorTestCase
{
    public function testIteratorArray()
    {
        $iterator = new OutputIterator(['foo' => new Output('buff')]);
        
        foreach ($iterator as $key => $item) {
            $this->assertSame('foo', $key);
        }
    }
}
