<?php


namespace Shardman\Service\Config;

/**
 * Class ConfigProvider
 * @package Shardman\Service\Config
 */
class ConfigProvider
{
    /**
     * @var Config[] list of configs indexed by map name
     */
    private $configs = [];

    /**
     * @param array $configs [shardMapId => shardConfigFile] OR [shardMapId => [...shardConfig...]]
     */
    public function __construct(array $configs)
    {
        foreach ($configs as $id => $data) {
            $this->loadConfig($id, $data);
        }
    }

    /**
     * @param $id
     * @param $data
     */
    protected function loadConfig($id, $data)
    {
        if (is_array($data)) {
            $this->configs[$id] = new Config($data);
        } else {
            $loader = new PhpFileConfigLoader($data);
            $this->configs[$id] = $loader->getConfig();
        }
    }

    /**
     * @param $id
     * @return Config
     * @throws NoConfigFoundException
     */
    public function getConfig($id)
    {
        if (!isset($this->configs[$id])) {
            throw new NoConfigFoundException(sprintf("Config %s not found", $id));
        }

        return $this->configs[$id];
    }

    /**
     * @return Config[]
     */
    public function getConfigs()
    {
        return $this->configs;
    }
}