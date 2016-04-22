<?php

namespace Shardman\Test\Service\ShardSelector;

use Shardman\Collection\ShardCollection;
use Shardman\Factory\ResultFactory;
use Shardman\Interfaces\BucketResult;
use Shardman\Service\ShardSelector\Crc32ShardSelector;
use Shardman\Test\BaseTestCase;

class Crc32ShardSelectorTest extends BaseTestCase
{
    /**
     * @dataProvider collectionProvider
     */
    public function testNormalOperation(ShardCollection $collection)
    {
        $key = 'testShardingKey';
        $expectedBucket = crc32($key) % 4;
        $selector = new Crc32ShardSelector();

        $result = $selector->getByKey($key, $collection);
        $this->assertInstanceOf(BucketResult::class, $result);
        $this->assertSame($expectedBucket, $result->getBucket());
        $this->assertSame($result, $selector->getLastSelected());

        $selector->setResultFactory(new ResultFactory());

        $result = $selector->getByKey($key, $collection);
        $this->assertInstanceOf(BucketResult::class, $result);
        $this->assertSame($expectedBucket, $result->getBucket());
        $this->assertSame($result, $selector->getLastSelected());
    }
}