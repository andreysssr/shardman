<?php


namespace Shardman\Test\Model;

use Shardman\Model\BucketRange;
use Shardman\Model\BucketResult;
use Shardman\Model\Shard;
use Shardman\Test\BaseTestCase;

class BucketResultTest extends BaseTestCase
{
    public function testGetters()
    {
        $shard = new Shard('shard01', [
            new BucketRange()
        ]);
        $r = new BucketResult($shard, 0);

        $this->assertTrue($r->getShard() === $shard);
        $this->assertEquals(0, $r->getBucket());
    }
}