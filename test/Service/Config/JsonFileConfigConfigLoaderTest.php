<?php


namespace Shardman\Test\Service\Config;


use Shardman\Service\Config\Config;
use Shardman\Service\Config\JsonFileConfigLoader;
use Shardman\Test\BaseTestCase;

class JsonFileConfigLoaderTest extends BaseTestCase
{
    public function testNormalOperation()
    {
        $loader = new JsonFileConfigLoader(__DIR__.'/../../Fixture/config/default.json');
        $this->assertInstanceOf(Config::class, $loader->getConfig());
        $this->assertEquals(2, count($loader->getConfig()->getShardConfig()));
    }

    /**
     * @expectedException \Shardman\Exception\FileNotFoundException
     */
    public function testFileNotFound()
    {
        new JsonFileConfigLoader('non-existent-'.microtime(true));
    }
}