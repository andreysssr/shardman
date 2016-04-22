<?php


namespace Shardman\Test\Service;

use Shardman\Collection\ShardCollection;
use Shardman\Model\BucketRange;
use Shardman\Model\Result;
use Shardman\Model\Shard;
use Shardman\Service\AbstractShardManager;
use Shardman\Service\ShardSelector\Crc32ShardSelector;
use Shardman\Test\BaseTestCase;

class AbstractShardManagerTest extends BaseTestCase
{
    /**
     * @param $collection ShardCollection
     * @dataProvider collectionProvider
     */
    public function testNormalOperation(ShardCollection $collection)
    {
        $result = new Result($collection[0]);
        $selector = $this->getMock(Crc32ShardSelector::class);
        $selector->expects($this->any())->method('getByKey')->willReturn($result);
        $selector->expects($this->any())->method('getByBucketId')->willReturn($collection[0]);

        $mock = $this->getMockForAbstractClass(AbstractShardManager::class, [
            $selector,
            $collection
        ]);

        $key = 'testKey';
        $this->assertSame($result, $mock->getByKey($key));
        $this->assertSame($collection[0], $mock->getByBucketId(1));
        $this->assertSame(['shard01'], $mock->getShardIds());

        $execResult = $mock->execAll(
            function ($shardId) {
                return $shardId . '-value';
            }
        );
        $this->assertSame(['shard01' => 'shard01-value'], $execResult);

        $execResult = $mock->execAll(
            function ($shardId) {
                return 1;
            },
            'array_sum'
        );
        $this->assertSame(1, $execResult);

        $execResult = $mock->execAll(
            function ($shardId) {
                return 1;
            },
            function ($result) {
                return 1 + array_sum($result);
            }
        );
        $this->assertSame(2, $execResult);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Collection must be continuous
     */
    public function testConstructorException()
    {
        $collection = new ShardCollection();
        $collection[] = new Shard('s01', [new BucketRange(0, 1)]);
        $collection[] = new Shard('s02', [new BucketRange(3, 4)]);
        $this->getMockForAbstractClass(AbstractShardManager::class, [
            new Crc32ShardSelector(),
            $collection
        ]);
    }
}