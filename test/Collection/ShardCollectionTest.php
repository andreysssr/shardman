<?php


namespace Shardman\Test\Collection;


use Shardman\Collection\ShardCollection;
use Shardman\Model\BucketRange;
use Shardman\Model\Shard;
use Shardman\Test\BaseTestCase;

class ShardCollectionTest extends BaseTestCase
{
    public function shardProvider()
    {
        $shard = new Shard('shard01', [
            new BucketRange(0, 2),
        ]);
        return [
            [$shard],
        ];
    }

    public function invalidArgumentProvider()
    {
        return [
            [null],
            [[]],
            [1],
            [''],
        ];
    }

    /**
     *
     * @dataProvider shardProvider
     * @param $shard Shard
     */
    public function testNormalOperation($shard)
    {
        $c    = new ShardCollection();
        $c[]  = $shard;
        $c[0] = $shard;
        $c['stringIndex'] = $shard;
        $this->assertEquals($shard, $c[0]);
        $this->assertEquals($shard, $c['stringIndex']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidArgument($value)
    {
        $c = new ShardCollection();
        $c[] = $value;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    public function testInvalidArgument2($value)
    {
        $c = new ShardCollection();
        $c[1] = $value;
    }

    /**
     *
     * @dataProvider shardProvider
     * @param $shard Shard
     */
    public function testIsContinuous($shard)
    {
        $c    = new ShardCollection();
        $c[]  = $shard;

        /** @var ShardCollection $c */
        $this->assertTrue($c->isContinuous());

        $c[]  = new Shard('shard02', [
            new BucketRange(4, 5),
        ]);

        $this->assertFalse($c->isContinuous());

        $c[]  = new Shard('shard03', [
            new BucketRange(3,3),
        ]);
        $this->assertTrue($c->isContinuous());
    }

    /**
     *
     * @dataProvider shardProvider
     * @param $shard Shard
     */
    public function testRandomShard($shard)
    {
        /** @var ShardCollection $c */
        $c   = new ShardCollection();
        $c[] = $shard;

        $this->assertEquals($shard, $c->getRandomShard());
    }
}