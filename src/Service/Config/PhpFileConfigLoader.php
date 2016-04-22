<?php


namespace Shardman\Service\Config;

use Shardman\Exception\FileNotFoundException;
use Shardman\Interfaces\ConfigLoader;

/**
 * Reads config from php file
 * Class PhpFileConfigLoader
 * @package Shardman\Service\Config
 */
class PhpFileConfigLoader implements ConfigLoader
{
    /**
     * @var Config
     */
    private $config;

    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException(sprintf('File %s is not found', $filename));
        }

        $this->config = new Config($this->readFile($filename));
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    protected function readFile($filename)
    {
        return include($filename);
    }
}