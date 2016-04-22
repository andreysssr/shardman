<?php


namespace Shardman\Test\Service\ShardSelector;

use Shardman\Collection\ShardCollection;
use Shardman\Factory\ResultFactory;
use Shardman\Model\Result;
use Shardman\Model\Shard;
use Shardman\Service\ShardSelector\AbstractShardSelector;
use Shardman\Test\BaseTestCase;

class AbstractShardSelectorTest extends BaseTestCase
{
    /**
     * @dataProvider defaultShardProvider
     */
    public function testGetByKey(Shard $shard)
    {
        /** @var AbstractShardSelector $mock */
        $mock = $this->getMockForAbstractClass(AbstractShardSelector::class);
        $mock->expects($this->any())
             ->method('getByKeyInternal')
             ->will($this->returnValue(new Result($shard)));

        $collection   = new ShardCollection();
        $collection[] = $shard;
        /** @var Result $result */
        $result = $mock->getByKey('testKey', $collection);
        $this->assertInstanceOf(Result::class, $result);
        $this->assertSame($shard, $result->getShard());
        $this->assertSame($result, $mock->getLastSelected());
    }

    /**
     * @dataProvider defaultShardProvider
     * @param Shard $shard
     */
    public function testGetShardByBucket(Shard $shard)
    {
        /** @var AbstractShardSelector $mock */
        $mock = $this->getMockForAbstractClass(AbstractShardSelector::class);
        $collection   = new ShardCollection();
        $collection[] = $shard;
        $result = $mock->getByBucketId(0, $collection);
        $this->assertSame($shard, $result);
    }

    public function testSetResultFactory()
    {
        /** @var AbstractShardSelector $mock */
        $mock = $this->getMockForAbstractClass(AbstractShardSelector::class);
        $mock->setResultFactory(new ResultFactory());
    }
}