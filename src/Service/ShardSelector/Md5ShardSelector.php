<?php


namespace Shardman\Service\ShardSelector;

/**
 * Class Md5ShardSelector. Selects a bucket by md5 has of $key
 * @package Shardman\Service\ShardSelector
 */
class Md5ShardSelector extends Crc32ShardSelector
{
    protected function getHash($key)
    {
        return md5($key);
    }

    protected function getModulo($hash, $divider)
    {
        return (int) bcmod(static::bchexdec($hash), $divider);
    }

    /**
     * Returns decimal representation of huge hex numbers
     * @param $hex
     * @return string
     */
    public static function bchexdec($hex) {
        if(!$hex || strlen($hex) == 1) {
            return (string) hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last   = substr($hex, -1);
            return bcadd(
                bcmul(16, static::bchexdec($remain)),
                hexdec($last)
            );
        }
    }
}