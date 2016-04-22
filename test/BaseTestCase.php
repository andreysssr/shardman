<?php
namespace Shardman\Test;

use Shardman\Collection\ShardCollection;
use Shardman\Model\BucketRange;
use Shardman\Model\Shard;
use Shardman\Service\Config\ConfigProvider;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    public function collectionProvider()
    {
        $c   = new ShardCollection();
        $c[] = $this->defaultShardProvider()[0][0];

        return [
            [$c],
        ];
    }

    public function defaultShardProvider()
    {
        $shard = new Shard('shard01', [
            new BucketRange(0, 3),
        ]);
        return [
            [$shard],
        ];
    }

    public function configProvider()
    {
        /** @var ConfigProvider $configProvider */
        $configProvider = new \Shardman\Service\Config\ConfigProvider($this->getConfigs());
        return [
            [$configProvider->getConfig('default')],
        ];
    }

    public function getConfigs()
    {
        return [
            'default' => __DIR__.'/Fixture/config/default.php',
            'array'   => $this->getValidShardConfig(),
        ];
    }

    public function getValidShardConfig()
    {
        return
            [
                'shards' => [
                    [
                        'id' => 'shard01',
                        'bucketRanges' => [
                            [
                                'start' => 0,
                                'end'   => 1,
                            ]
                        ],
                    ],
                ],
            ];
    }

    public function validConfigsProvider()
    {
        return [
            [$this->getValidShardConfig()],
        ];
    }
}