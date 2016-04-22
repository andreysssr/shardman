<?php

namespace Shardman\Test\Model;

use Shardman\Model\BucketRange;
use Shardman\Model\Result;
use Shardman\Model\Shard;
use Shardman\Test\BaseTestCase;

class ResultTest extends BaseTestCase
{
    public function testGetters()
    {
        $shard = new Shard('shard01', [
            new BucketRange()
        ]);
        $r = new Result($shard);

        $this->assertTrue($r->getShard() === $shard);
    }
}