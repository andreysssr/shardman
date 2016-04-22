<?php


namespace Service\Config;


use Shardman\Service\Config\Config;
use Shardman\Test\BaseTestCase;

class ConfigTest extends BaseTestCase
{
    /**
     * @param $config
     * @dataProvider validConfigsProvider
     */
    public function testNormalConstructionAndValidation($config)
    {
        new Config($config);
    }

    /**
     * @dataProvider invalidConfigsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testValidationException($config)
    {
        new Config($config);
    }

    /**
     * @param $configData
     * @dataProvider validConfigsProvider
     */
    public function testGetConfig($configData)
    {
        $config = new Config($configData);
        $this->assertEquals($configData, $config->getConfig());
    }

    /**
     * @param $configData
     * @dataProvider validConfigsProvider
     */
    public function testGetShardConfig($configData)
    {
        $config = new Config($configData);
        $this->assertEquals($configData['shards'], $config->getShardConfig());
    }

    public function invalidConfigsProvider()
    {
        return [
            [[]],

            // - no shard id - //

            [
                [
                    'shards' => [
                        [
                            'bucketRanges' => [
                                [
                                    'start' => 0,
                                    'end'   => 1,
                                ]
                            ],
                        ],
                    ],
                ],
            ],

            // - duplicate shard id's - //
            [
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

                        [
                            'id' => 'shard01',
                            'bucketRanges' => [
                                [
                                    'start' => 2,
                                    'end'   => 3,
                                ]
                            ],
                        ],
                    ],
                ],
            ],

            // - overlapping bucket ranges - //
            [
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

                        [
                            'id' => 'shard01',
                            'bucketRanges' => [
                                [
                                    'start' => 1,
                                    'end'   => 2,
                                ]
                            ],
                        ],
                    ],
                ],
            ],

            // - no bucketRanges - //

            [
                [
                    'shards' => [
                        [
                            'id' => 'shard01',
                        ],
                    ],
                ],
            ],

            // - empty bucket ranges - //
            [
                [
                    'shards' => [
                        [
                            'id' => 'shard01',
                            'bucketRanges' => [
                            ],
                        ],
                    ],
                ],
            ],

            // - wrong bucket range - //
            [
                [
                    'shards' => [
                        [
                            'id' => 'shard01',
                            'bucketRanges' => [
                                [
                                    'start' => 1,
                                    'end'   => 0,
                                ]
                            ],
                        ],
                    ],
                ],
            ],

        ];
    }
}