<?php

namespace Shardman\Interfaces;
use Shardman\Model\BucketRange;

/**
 * Interface Shard
 * @package Shardman\Interfaces
 */
interface Shard
{
    /**
     * Returns id of this shard
     * @return string
     */
    public function getId();

    /**
     * @param $bucketId
     * @return bool
     */
    public function hasBucket($bucketId);

    /**
     * @return int
     */
    public function getMinBucket();

    /**
     * @return int
     */
    public function getMaxBucket();

    /**
     * @return int
     */
    public function getRandomBucket();

    /**
     * @return BucketRange[]
     */
    public function getBucketRanges();

    /**
     * Returns total number of buckets in current shard
     * @return int
     */
    public function getBucketNumber();
}