<?php


namespace Shardman\Service\ShardSelector;


use Shardman\Collection\ShardCollection;
use Shardman\Model\Result;
use Shardman\Service\ShardSelector\Persister\Persister;
use Shardman\Service\ShardSelector\Persister\PersisterException;

/**
 * Class PersistentRandomShardSelector.
 * Selects a random bucket for key and stores it in a persistent storage.
 * @package Shardman\Service\ShardSelector
 */
class PersistentRandomShardSelector extends AbstractShardSelector
{
    /**
     * @var Persister
     */
    private $persister;

    /**
     * @var string
     */
    private $keyPrefix;

    /**
     * @param Persister $persister
     * @param string $keyPrefix
     */
    public function __construct(Persister $persister, $keyPrefix = 'PersistentRandomShardSelector.key.')
    {
        $this->persister = $persister;
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * @param $key
     * @param ShardCollection $collection
     * @return \Shardman\Model\Result
     * @throws PersisterException
     */
    protected function getByKeyInternal($key, ShardCollection $collection)
    {
        $bucket = 0;
        $persistedKey = $this->createPersistedKey($key);
        $shard  = $collection->getRandomShard();
        if ($this->persister->add($persistedKey, $shard->getId())) {
            return new Result($shard, $bucket);
        }

        $shardId = $this->persister->get($persistedKey);
        if (false === $shardId) {
            throw new PersisterException("Persister error, unable to add or get key");
        }
        foreach ($collection as $shard) {
            if ($shard->getId() === $shardId) {
                return new Result($shard, $bucket);
            }
        }

        throw new NoResultException("Shard not found");
    }

    protected function createPersistedKey($key)
    {
        return $this->keyPrefix.$key;
    }
}