<?php
namespace Shardman\Service\ShardSelector;

use Shardman\Collection\ShardCollection;
use Shardman\Factory\ResultFactory;
use Shardman\Interfaces\Result;
use Shardman\Interfaces\Shard;
use Shardman\Interfaces\ShardSelector;

/**
 * Class AbstractShardSelector
 * @package Shardman\Service\ShardSelector
 */
abstract class AbstractShardSelector implements ShardSelector
{
    /**
     * @var Result
     */
    private $lastSelected;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @inheritdoc
     */
    public function getByKey($key, ShardCollection $collection)
    {
        return $this->lastSelected = $this->getByKeyInternal($key, $collection);
    }

    /**
     * @param $key
     * @param ShardCollection $collection
     * @return mixed
     */
    protected abstract function getByKeyInternal($key, ShardCollection $collection);

    /**
     * @inheritdoc
     */
    public function getLastSelected()
    {
        return $this->lastSelected;
    }

    /**
     * @param ResultFactory $resultFactory
     */
    public function setResultFactory(ResultFactory $resultFactory)
    {
        $this->resultFactory = $resultFactory;
    }

    /**
     * @inheritdoc
     */
    public function getByBucketId($bucketId, ShardCollection $collection)
    {
        /** @var Shard $shard */
        foreach ($collection as $shard) {
            if ($shard->hasBucket($bucketId)) {
                return $shard;
            }
        }

        return false;
    }
}