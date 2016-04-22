<?php


namespace Shardman\Model;

use \Shardman\Interfaces\BucketResult as BucketResultInterface;
use \Shardman\Interfaces\Shard as ShardInterface;

class BucketResult extends Result implements BucketResultInterface
{
    /**
     * Selected bucket id
     * @var integer
     */
    private $bucket;

    public function __construct(ShardInterface $shard, $bucket)
    {
        parent::__construct($shard);
        $this->bucket = $bucket;
    }

    /**
     * @return int
     */
    public function getBucket()
    {
        return $this->bucket;
    }
}