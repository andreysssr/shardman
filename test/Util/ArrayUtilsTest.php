<?php


namespace Shardman\Test\Utils;


use Shardman\Test\BaseTestCase;
use Shardman\Util\ArrayUtils;

class ArrayUtilsTest extends BaseTestCase
{

    public function testMtrand()
    {
        $this->assertContains(ArrayUtils::mtrand([0, 1]), [0, 1]);
        $this->assertContains(ArrayUtils::mtrandKey([0, 1]), [0, 1]);

        $this->assertNotContains(ArrayUtils::mtrand([0, 1]), [2, 3]);
        $this->assertNotContains(ArrayUtils::mtrandKey([0, 1]), [2, 3]);

        $this->assertEquals(ArrayUtils::mtrand([]), null);
        $this->assertEquals(ArrayUtils::mtrandKey([]), null);

        $this->assertEquals(ArrayUtils::mtrand([0]), 0);
        $this->assertEquals(ArrayUtils::mtrandKey([0]), 0);
    }
}