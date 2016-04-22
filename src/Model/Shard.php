<?php
namespace Shardman\Model;

use Shardman\Util\ArrayUtils;
use \Shardman\Interfaces\Shard as ShardInterface;

/**
 * Class Shard
 * @package Shardman\Model
 */
class Shard implements ShardInterface
{
    /**
     * Shard id
     * @var string
     */
    private $id;

    /**
     * Bucket ranges in this shard
     * @var BucketRange[]
     */
    private $bucketRanges = [];

    /**
     * @param $id
     * @param array $buckets
     * @throws \InvalidArgumentException
     */
    public function __construct($id, array $buckets)
    {
        if ($id === null || $id === '') {
            throw new \InvalidArgumentException('Empty ids not allowed');
        }

        if (!$buckets) {
            throw new \InvalidArgumentException('No buckets specified');
        }

        $this->id = $id;
        $this->setBucketRanges($buckets);
    }

    /**
     * @inheritdoc
     */
    public function hasBucket($bucketId)
    {
        /** @var BucketRange $bucketRange */
        foreach ($this->getBucketRanges() as $bucketRange) {
            if ($bucketRange->contains($bucketId)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function getMinBucket()
    {
        $buckets = $this->getBucketRanges();
        /** @var BucketRange $first */
        $first   = reset($buckets);

        return $first->getStart();
    }

    /**
     * @inheritdoc
     */
    public function getMaxBucket()
    {
        $buckets = $this->getBucketRanges();
        /** @var BucketRange $last */
        $last   = end($buckets);

        return $last->getEnd();
    }

    /**
     * @inheritdoc
     */
    public function getRandomBucket()
    {
        /** @var BucketRange $range */
        $range = ArrayUtils::mtrand($this->getBucketRanges());
        return mt_rand($range->getStart(), $range->getEnd());
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getBucketNumber()
    {
        $result = 0;
        foreach($this->getBucketRanges() as $bucketRange) {
            $result += $bucketRange->getBucketNumber();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function getBucketRanges()
    {
        return $this->bucketRanges;
    }

    /**
     * @param array $bucketRanges
     */
    protected function setBucketRanges(array $bucketRanges)
    {
        foreach ($bucketRanges as $bucketRange) {
            if (!($bucketRange instanceof BucketRange)) {
                throw new \InvalidArgumentException('Bucket range item should be an instance of Shardman\Model\BucketRange');
            }
        }
        $this->bucketRanges = $bucketRanges;
    }
}