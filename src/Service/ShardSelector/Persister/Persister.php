<?php


namespace Shardman\Service\ShardSelector\Persister;

/**
 * Interface Persister. Represents a hash table for storing sharding key to bucket mapping
 * @package Shardman\Service\ShardSelector\Persister
 */
interface Persister
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value);

    /**
     * Adds an element to table if it doesn't exist, otherwise returns false.
     * @param $key
     * @param $value
     * @return bool
     */
    public function add($key, $value);
}