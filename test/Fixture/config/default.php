<?php
return [
    'shards' => [
        [
            'id' => 'shard01',
            'bucketRanges' => [
                [
                    'start' => 0,
                    'end'   => 49999,
                ],
            ],
        ],

        [
            'id' => 'shard02',
            'bucketRanges' => [
                [
                    'start' => 50000,
                    'end'   => 100000,
                ],
            ],
        ],
    ],
];