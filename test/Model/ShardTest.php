<?php
namespace Shardman\Test\Model;

use Shardman\Interfaces\Shard as ShardInterface;
use Shardman\Model\BucketRange;
use Shardman\Model\Shard;
use Shardman\Test\BaseTestCase;

class ShardTest extends BaseTestCase
{
    public function twoBucketRangesShardProvider()
    {
        return [
            [
                new Shard('shard01', [
                    new BucketRange(0, 1),
                    new BucketRange(2, 3),
                ]),
            ],
        ];
    }

    public function commonShardProvider()
    {
        return array_merge($this->defaultShardProvider(), $this->twoBucketRangesShardProvider());
    }

    /**
     * @dataProvider defaultShardProvider
     * @param $shard
     */
    public function testInstanceof($shard)
    {
        $this->assertInstanceOf(ShardInterface::class, $shard);
    }

    /**
     * @dataProvider defaultShardProvider
     * @param $shard Shard
     */
    public function testConstructor($shard)
    {
        $this->assertCount(1, $shard->getBucketRanges());
        $this->assertEquals('shard01', $shard->getId());
    }

    /**
     * @dataProvider twoBucketRangesShardProvider
     * @param $shard Shard
     */
    public function testConstructorWithTwoRanges($shard)
    {
        $this->assertCount(2, $shard->getBucketRanges());
        $this->assertEquals('shard01', $shard->getId());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException1()
    {
        new \Shardman\Model\Shard('shard01', [
            [1, 3, 5],
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException2()
    {
        new \Shardman\Model\Shard('shard01', [
            [],
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorException3()
    {
        new \Shardman\Model\Shard('', [new BucketRange(0,2)]);
    }

    /**
     * @dataProvider commonShardProvider
     * @param $shard Shard
     */
    public function testRandomBucket($shard)
    {
        $this->assertContains($shard->getRandomBucket(), range(0, 3));
    }

    public function testRandomBucketForOneBucketSpecified()
    {
        $shard = new \Shardman\Model\Shard('shard01', [
            new BucketRange(),
        ]);
        $this->assertEquals(0, $shard->getRandomBucket());
    }

    /**
     * @dataProvider commonShardProvider
     * @param $shard Shard
     */
    public function testMinMax($shard)
    {
        $this->assertEquals(0, $shard->getMinBucket());
        $this->assertEquals(3, $shard->getMaxBucket());
    }

    /**
     * @dataProvider commonShardProvider
     * @param $shard Shard
     */
    public function testHasBucket($shard)
    {
        $this->assertTrue($shard->hasBucket(0));
        $this->assertTrue($shard->hasBucket(1));
        $this->assertTrue($shard->hasBucket(2));
        $this->assertTrue($shard->hasBucket(3));
        $this->assertFalse($shard->hasBucket(4));
    }

    /**
     * @dataProvider commonShardProvider
     * @param $shard Shard
     */
    public function testGetBucketNumber($shard)
    {
        $this->assertEquals(4, $shard->getBucketNumber());
    }
}