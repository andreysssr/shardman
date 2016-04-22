<?php


namespace Shardman\Service;


use \InvalidArgumentException;
use Shardman\Collection\ShardCollection;
use Shardman\Interfaces\Shard;
use Shardman\Interfaces\ShardManager;
use Shardman\Interfaces\ShardSelector;

/**
 * Class AbstractShardManager
 * @package Shardman\Service
 */
abstract class AbstractShardManager implements ShardManager
{
    /**
     * @var ShardCollection
     */
    private $collection;
    /**
     * @var ShardSelector
     */
    private $selector;

    /**
     * @param ShardSelector $selector
     * @param ShardCollection $collection
     */
    public function __construct(ShardSelector $selector, ShardCollection $collection)
    {
        if (!$collection->isContinuous()) {
            throw new InvalidArgumentException("Collection must be continuous");
        }
        $this->selector   = $selector;
        $this->collection = $collection;
    }

    /**
     * @inheritdoc
     */
    public function getByKey($key)
    {
        return $this->getSelector()->getByKey($key, $this->getCollection());
    }

    /**
     * @inheritdoc
     */
    public function getByBucketId($bucketId)
    {
        return $this->selector->getByBucketId($bucketId, $this->getCollection());
    }

    /**
     * @return ShardSelector
     */
    protected function getSelector()
    {
        return $this->selector;
    }

    /**
     * @return ShardCollection
     */
    protected function getCollection()
    {
        return $this->collection;
    }

    /**
     * @inheritdoc
     */
    public function getShardIds()
    {
        $ids = [];
        /** @var Shard $shard */
        foreach ($this->collection as $shard) {
            $ids[] = $shard->getId();
        }

        return $ids;
    }

    /**
     * @inheritdoc
     */
    public function execAll(callable $callback, callable $finalize = null)
    {
        $result = [];
        foreach ($this->getShardIds() as $shardId) {
            $result[$shardId] = $callback($shardId);
        }

        return $finalize ? $finalize($result) : $result;
    }
}