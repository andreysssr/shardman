<?php


namespace Shardman\Test\Service\Config;


use Shardman\Service\Config\Config;
use Shardman\Service\Config\PhpFileConfigLoader;
use Shardman\Test\BaseTestCase;

class PhpFileConfigLoaderTest extends BaseTestCase
{
    public function testNormalOperation()
    {
        $loader = new PhpFileConfigLoader(__DIR__.'/../../Fixture/config/default.php');
        $this->assertInstanceOf(Config::class, $loader->getConfig());
        $this->assertEquals(2, count($loader->getConfig()->getShardConfig()));
    }

    /**
     * @expectedException \Shardman\Exception\FileNotFoundException
     */
    public function testFileNotFound()
    {
        new PhpFileConfigLoader('non-existent-'.microtime(true));
    }
}