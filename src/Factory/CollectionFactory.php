<?php

namespace Shardman\Factory;

use Shardman\Collection\ShardCollection;
use Shardman\Service\Config\Config;
use Shardman\Model\BucketRange;
use Shardman\Model\Shard;

/**
 * Class CollectionFactory. Creates ShardCollection.
 * @package Shardman\Factory
 */
class CollectionFactory
{
    /**
     * @param Config $config
     * @return ShardCollection
     */
    public static function create(Config $config)
    {
        $c = new ShardCollection();
        foreach ($config->getShardConfig() as $shardConfig) {
            $bucketRanges = [];
            foreach ($shardConfig['bucketRanges'] as $bucketRangeConfig) {
                $bucketRanges[] = new BucketRange($bucketRangeConfig['start'], $bucketRangeConfig['end']);
            }

            $c[] = new Shard($shardConfig['id'], $bucketRanges);
        }

        return $c;
    }
}