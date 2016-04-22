<?php


namespace Shardman\Interfaces;


interface BucketResult extends Result
{
    /**
     * @return int
     */
    public function getBucket();
}