<?php

namespace Shardman\Service\ShardSelector\Persister;

/**
 * Class InMemoryPersister. Stores key => value pairs in simple array.
 * @package Shardman\Service\ShardSelector\Persister
 */
class InMemoryPersister implements Persister
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return isset($this->storage[$key]) ? $this->storage[$key] : false;
    }

    /**
     * @inheritdoc
     */
    public function set($key, $value)
    {
        $this->storage[$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function add($key, $value)
    {
        if (!isset($this->storage[$key])) {
            $this->set($key, $value);
            return true;
        } else {
            return false;
        }
    }
}