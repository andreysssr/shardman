<?php


namespace Shardman\Test\Service\ShardSelector;


use Shardman\Collection\ShardCollection;
use Shardman\Interfaces\Shard;
use Shardman\Service\ShardSelector\NoResultException;
use Shardman\Service\ShardSelector\PersistentRandomShardSelector;
use Shardman\Service\ShardSelector\Persister\InMemoryPersister;
use Shardman\Test\BaseTestCase;

class PersistentRandomShardSelectorTest extends BaseTestCase
{
    /**
     * @param ShardCollection $collection
     * @throws \Exception
     * @dataProvider collectionProvider
     */
    public function testNormalOperation(ShardCollection $collection)
    {
        $key = 'testKey';
        $shardIds  = array_map(function (Shard $shard) {
            return $shard->getId();
        }, $collection->getArrayCopy());

        $persister = new InMemoryPersister();
        $selector  = new PersistentRandomShardSelector($persister, 'testKeyPrefix.');
        $result    = $selector->getByKey($key, $collection);
        $this->assertContains($result->getShard()->getId(), $shardIds);

        $result2 = $selector->getByKey($key, $collection);
        $this->assertSame($result->getShard(), $result2->getShard());
    }

    /**
     * @param ShardCollection $collection
     * @dataProvider collectionProvider
     * @expectedException \Shardman\Service\ShardSelector\NoResultException
     * @expectedExceptionMessage Shard not found
     */
    public function testNonExistentShardInMemoryException(ShardCollection $collection)
    {

        $persister = new InMemoryPersister();
        $selector  = new PersistentRandomShardSelector($persister, 'testKeyPrefix.');

        $persister->set('testKeyPrefix.testKey', 'non-existent-shard-id');
        $selector->getByKey('testKey', $collection);
    }

    /**
     * @param ShardCollection $collection
     * @throws \Exception
     * @dataProvider collectionProvider
     * @expectedException \Shardman\Service\ShardSelector\Persister\PersisterException
     * @expectedExceptionMessage Persister error, unable to add or get key
     */
    public function testException(ShardCollection $collection)
    {
        $mock = $this->getMock(InMemoryPersister::class);
        $mock->expects($this->any())
                ->method('get')
                ->willReturn(false);

        $mock->expects($this->any())
                ->method('add')
                ->willReturn(false);

        $key = 'testKey';
        $selector = new PersistentRandomShardSelector($mock);
        $selector->getByKey($key, $collection);
    }
}