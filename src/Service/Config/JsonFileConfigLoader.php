<?php


namespace Shardman\Service\Config;


class JsonFileConfigLoader extends PhpFileConfigLoader
{
    protected function readFile($filename)
    {
        return json_decode(file_get_contents($filename), true);
    }
}