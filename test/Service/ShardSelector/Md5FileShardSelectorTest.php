<?php


namespace Shardman\Test\Service\ShardSelector;


use Shardman\Collection\ShardCollection;
use Shardman\Service\ShardSelector\Md5FileShardSelector;
use Shardman\Test\BaseTestCase;

class Md5FileShardSelectorTest extends BaseTestCase
{
    /**
     * @param ShardCollection $collection
     * @throws \Exception
     * @dataProvider collectionProvider
     */
    public function testNormalOperation(ShardCollection $collection)
    {
        $path = __DIR__.'/../../Fixture/config/default.php';

        $selector = new Md5FileShardSelector();
        $result   = $selector->getByKey($path, $collection);
        $md5      = md5_file($path);
        $bucket   = (int) bcmod(Md5FileShardSelector::bchexdec($md5), 4);

        $this->assertSame($bucket, $result->getBucket());
    }
}