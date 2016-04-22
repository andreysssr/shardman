<?php


namespace Shardman\Factory;


use Shardman\Interfaces\Shard;
use Shardman\Model\Result;

/**
 * Class ResultFactory, creates Result
 * @package Shardman\Factory
 */
class ResultFactory
{
    /**
     * @param Shard $shard
     * @return Result
     */
    public function create(Shard $shard)
    {
        return new Result($shard);
    }
}