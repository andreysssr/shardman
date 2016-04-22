<?php
namespace Shardman\Model;

use Shardman\Interfaces\Shard as ShardInterface;
use \Shardman\Interfaces\Result as ResultInterface;

/**
 * Class Result
 * @package Shardman\Model
 */
class Result implements ResultInterface
{
    /**
     * selected shard
     * @var ShardInterface
     */
    private $shard;

    public function __construct(ShardInterface $shard)
    {
        $this->shard = $shard;
    }

    /**
     * @return ShardInterface
     */
    public function getShard()
    {
        return $this->shard;
    }
}