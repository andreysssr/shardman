<?php


namespace Shardman\Service\Config;

/**
 * Class Config. Represents a single shard map.
 * @package Shardman\Service\Config
 */
class Config
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->validateConfig();
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return array
     */
    public function getShardConfig()
    {
        $cfg = $this->getConfig();
        return $cfg['shards'];
    }

    /**
     * @return void
     */
    protected function validateConfig()
    {
        if (empty($this->config['shards'])) {
            throw new \InvalidArgumentException('No shards configured');
        }

        $idCounts = [];
        foreach ($this->config['shards'] as $shard) {
            if (empty($shard['id'])) {
                throw new \InvalidArgumentException('No shard id specified');
            }

            if (empty($shard['bucketRanges'])) {
                throw new \InvalidArgumentException('No bucket ranges specified');
            }

            foreach ($shard['bucketRanges'] as $bucketRange) {
                if (!isset($bucketRange['start'], $bucketRange['end']) || $bucketRange['start'] > $bucketRange['end']) {
                    throw new \InvalidArgumentException('Wrong bucket range specification');
                }
            }

            $idCounts[$shard['id']] = empty($idCounts[$shard['id']]) ? 1 : $idCounts[$shard['id']] + 1;
            if ($idCounts[$shard['id']] > 1) {
                throw new \InvalidArgumentException('Duplicate shard id\'s found');
            }
        }
    }
}