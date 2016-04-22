<?php
namespace Shardman\Interfaces;

use Shardman\Collection\ShardCollection;

/**
 * Interface ShardSelectorInterface
 * @package Shardman\Interfaces
 */
interface ShardSelector
{

    /**
     * Matches entity key to bucket number
     * @param $key
     * @param $collection ShardCollection
     * @return Result
     */
    public function getByKey($key, ShardCollection $collection);

    /**
     * Returns result of the last selection
     * @return Result
     */
    public function getLastSelected();

    /**
     * @param $bucketId
     * @param ShardCollection $collection
     * @return Shard|false
     */
    public function getByBucketId($bucketId, ShardCollection $collection);
}