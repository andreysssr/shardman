<?php


namespace Shardman\Model;

/**
 * Class BucketRange.
 * Represents bucket range so you don't need to specify
 * every single bucket stored on the shard.
 * Both $start and $end are inclusive.
 * @package Shardman\Model
 */
class BucketRange
{
    /**
     * Starting bucket id
     * @var int
     */
    private $start = 0;

    /**
     * Ending bucket id
     * @var int
     */
    private $end = 0;

    /**
     * @param int $start
     * @param int $end
     */
    public function __construct($start = 0, $end = 0)
    {
        if ($start > $end) {
            throw new \InvalidArgumentException('Start must be less than or equal to end');
        }

        if ($start < 0 || $end < 0) {
            throw new \InvalidArgumentException('Start & end should be greater than zero');
        }
        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * @param $bucketId
     * @return bool
     */
    public function contains($bucketId)
    {
        return $bucketId >= $this->getStart() && $bucketId <= $this->getEnd();
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getBucketNumber()
    {
        return $this->getEnd() - $this->getStart() + 1;
    }
}