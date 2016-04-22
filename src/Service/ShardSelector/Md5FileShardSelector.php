<?php


namespace Shardman\Service\ShardSelector;


use Shardman\Exception\FileNotFoundException;

/**
 * Class Md5FileShardSelector. Selects bucket by the contents of the file specified by $key
 * @package Shardman\Service\ShardSelector
 */
class Md5FileShardSelector extends Md5ShardSelector
{
    /**
     * $key here is a path of a file.
     * @inheritdoc
     */
    protected function getHash($key)
    {
        if (!file_exists($key)) {
            throw new FileNotFoundException("File $key not found");
        }
        return md5_file($key);
    }
}