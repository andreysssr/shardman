<?php


namespace Shardman\Test\Factory;


use Shardman\Collection\ShardCollection;
use Shardman\Factory\CollectionFactory;
use Shardman\Service\Config\Config;
use Shardman\Test\BaseTestCase;

class CollectionFactoryTest extends BaseTestCase
{
    /**
     * @dataProvider configProvider
     * @param Config $config
     */
    public function testFactory(Config $config)
    {
        $c = CollectionFactory::create($config);
        $this->assertInstanceOf(ShardCollection::class, $c);
        $this->assertEquals(2, $c->count());
    }
}