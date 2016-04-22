<?php


namespace Shardman\Test\Service\ShardSelector;

use Shardman\Collection\ShardCollection;
use Shardman\Service\ShardSelector\Md5ShardSelector;
use Shardman\Test\BaseTestCase;

class Md5ShardSelectorTest extends BaseTestCase
{
    public function testBchexdec()
    {
        $this->assertSame('0', Md5ShardSelector::bchexdec(''));
        $this->assertSame('0', Md5ShardSelector::bchexdec('0'));
        $this->assertSame('0', Md5ShardSelector::bchexdec(0));
        $this->assertSame('65535', Md5ShardSelector::bchexdec('ffff'));
    }

    /**
     * @param ShardCollection $collection
     * @throws \Exception
     * @dataProvider collectionProvider
     */
    public function testNormalOperation(ShardCollection $collection)
    {
        $key      = 'testKey';
        $selector = new Md5ShardSelector();
        $md5      = md5($key);
        $bucket   = (int) bcmod(Md5ShardSelector::bchexdec($md5), 4);
        $result   = $selector->getByKey($key, $collection);
        $this->assertSame($bucket, $result->getBucket());
    }
}