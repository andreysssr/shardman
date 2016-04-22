<?php

namespace Shardman\Test\Model;

use Shardman\Model\BucketRange;
use Shardman\Test\BaseTestCase;

class BucketRangeTest extends BaseTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructStartGreaterThanEnd()
    {
        new BucketRange(1, 0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructNegative()
    {
        new BucketRange(0, -1);
    }

    public function testNormal()
    {
        $br = new BucketRange(0, 2);
        $this->assertEquals(0, $br->getStart());
        $this->assertEquals(2, $br->getEnd());
        $this->assertEquals(3, $br->getBucketNumber());
    }

    /**
     * @dataProvider containsProvider
     */
    public function testContains($start, $end, $testValue, $true = true)
    {
        $br = new BucketRange($start, $end);
        $fun = $true ? 'assertTrue' : 'assertFalse';
        $this->{$fun}($br->contains($testValue));
    }

    public function containsProvider()
    {
        return [
            [0, 0, 0],
            [0, 2, 0],
            [0, 2, 1],
            [0, 2, 2],
            [0, 2, 3, false],
        ];
    }
}