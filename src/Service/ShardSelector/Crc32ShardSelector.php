<?php

namespace Shardman\Service\ShardSelector;

use Shardman\Collection\ShardCollection;
use Shardman\Interfaces\Result;
use Shardman\Interfaces\Shard;
use Shardman\Model\BucketResult;

/**
 * Class Crc32ShardSelector
 * @package Shardman\Service\BucketSelector
 */
class Crc32ShardSelector extends AbstractShardSelector
{
    /**
     * @param $key
     * @param ShardCollection $collection
     * @return Result
     * @throws NoResultException
     */
    protected function getByKeyInternal($key, ShardCollection $collection)
    {
        $divider   = 0;
        $minBucket = false;
        /** @var Shard $shard */
        foreach ($collection as $shard) {
            $divider += $shard->getBucketNumber();
            $shardMinBucket = $shard->getMinBucket();
            if ($minBucket === false || $shardMinBucket < $minBucket) {
                $minBucket = $shardMinBucket;
            }
        }

        $hash    = $this->getHash($key);
        $bucket  = $this->getModulo($hash, $divider);
        $bucket += $minBucket;
        foreach ($collection as $shard) {
            if ($shard->hasBucket($bucket)) {
                return new BucketResult($shard, $bucket);
            }
        }

        throw new NoResultException('No bucket selected');
    }

    protected function getHash($key)
    {
        return sprintf('%u', crc32($key)); // prevent negative values on 32-bit systems
    }

    protected function getModulo($hash, $divider)
    {
        return $hash % $divider;
    }
}