<?php
namespace Shardman\Collection;

use Shardman\Interfaces\Shard;
use Shardman\Util\ArrayUtils;

/**
 * Class ShardCollection. Holds an array of Shard instances.
 * @package Shardman\Collection
 */
class ShardCollection extends \ArrayObject
{
    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function __construct($input = [], $flags = 0, $iterator_class = "ArrayIterator")
    {
        if (is_array($input)) {
            foreach ($input as $k => $v) {
                $this->checkItem($v);
            }
        }

        parent::__construct($input, $flags, $iterator_class);
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function offsetSet($index, $value)
    {
        $this->checkItem($value);
        parent::offsetSet($index, $value);
    }

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     */
    public function append($value)
    {
        $this->checkItem($value);
        parent::append($value);
    }

    /**
     * Checks whether the collection contains continuous range of buckets.
     * @return bool
     */
    public function isContinuous()
    {
        $this->uasort(function(Shard $a, Shard $b) {
            return $a->getMinBucket() - $b->getMinBucket();
        });

        /** @var Shard $v */
        $prevMax = false;
        foreach ($this as $v) {
            if (false !== $prevMax && $v->getMinBucket() !== $prevMax + 1) {
                return false;
            }
            $prevMax = $v->getMaxBucket();
        }

        return true;
    }

    /**
     * Returns random shard
     * @return Shard
     */
    public function getRandomShard()
    {
        return ArrayUtils::mtrand($this->getArrayCopy());
    }

    /**
     * Checks item type
     * @param $item
     */
    protected function checkItem($item)
    {
        if (!($item instanceof Shard)) {
            throw new \InvalidArgumentException('Item must be an instance of '.Shard::class);
        }
    }
}