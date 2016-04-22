<?php
namespace Shardman\Util;

/**
 * Class ArrayUtils
 * @package Shardman\Util
 */
class ArrayUtils
{

    /**
     * Returns random value from array using mt_rand().
     * @param array $array
     * @return mixed
     */
    public static function mtrand(array $array)
    {
        return self::mtrandInternal(array_values($array));

    }

    /**
     * Returns random key from array using mt_rand().
     * @param array $array
     * @return mixed
     */
    public static function mtrandKey(array $array)
    {
        return self::mtrandInternal(array_keys($array));
    }


    /**
     * Returns random value from array using mt_rand().
     * Array should be sequentially indexed.
     * @param array $array
     * @return mixed
     */
    protected static function mtrandInternal(array $array)
    {
        if (count($array) == 0) {
            return null;
        }
        $index = mt_rand(0, count($array) - 1);

        return $array[$index];
    }
}