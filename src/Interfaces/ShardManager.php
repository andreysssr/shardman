<?php


namespace Shardman\Interfaces;

/**
 * Interface ShardManager
 * @package Shardman\Interfaces
 */
interface ShardManager
{

    /**
     * Matches entity key to bucket number
     * @param $key
     * @return Result
     */
    public function getByKey($key);

    /**
     * Matches bucketId to shardId
     * @param $bucketId
     * @return Result
     */
    public function getByBucketId($bucketId);

    /**
     * Returns array of shard ids
     * @return string[]
     */
    public function getShardIds();

    /**
     * Executes function $callback against all shards and applies $finalize to the result.
     * @param callable $callback
     * @param callable $finalize
     * @return mixed
     */
    public function execAll(callable $callback, callable $finalize = null);
}