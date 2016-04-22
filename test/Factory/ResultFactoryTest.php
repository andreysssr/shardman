<?php


namespace Shardman\Test\Factory;


use Shardman\Factory\ResultFactory;
use Shardman\Model\BucketRange;
use Shardman\Model\Result;
use Shardman\Model\Shard;
use Shardman\Test\BaseTestCase;

class ResultFactoryTest extends BaseTestCase
{
    public function testResultFactory()
    {
        $shard = new Shard('shard01', [
            new BucketRange(0, 2),
        ]);

        $bucket = 1;
        $f      = new ResultFactory();
        $result = $f->create($shard, $bucket);
        $this->assertInstanceOf(Result::class, $result);
    }
}