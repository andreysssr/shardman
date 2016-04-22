<?php


namespace Shardman\Test\Service\Config;


use Shardman\Service\Config\Config;
use Shardman\Service\Config\ConfigProvider;
use Shardman\Test\BaseTestCase;

class ConfigProviderTest extends BaseTestCase
{
    public function createConfigProvider()
    {
        return new ConfigProvider($this->getConfigs());
    }

    public function testNormalOperation()
    {
        $configProvider = $this->createConfigProvider();
        $this->assertNotEmpty($configProvider->getConfig('default'));
        $this->assertNotEmpty($configProvider->getConfig('array'));
        $ids = array_keys($this->getConfigs());
        foreach ($configProvider->getConfigs() as $id => $config) {
            $this->assertInstanceOf(Config::class, $config);
            $this->assertContains($id, $ids);
        }
    }

    /**
     * @expectedException \Shardman\Service\Config\NoConfigFoundException
     */
    public function testConfigNotFoundException()
    {
        $configProvider = $this->createConfigProvider();
        $configProvider->getConfig('non-existent');
    }
}