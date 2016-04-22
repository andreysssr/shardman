<?php


namespace Shardman\Test\Service\Persister;

use Shardman\Service\ShardSelector\Persister\InMemoryPersister;
use Shardman\Service\ShardSelector\Persister\Persister;
use Shardman\Test\BaseTestCase;

class InMemoryPersisterTest extends BaseTestCase
{
    public function testGetSet()
    {
        $p = new InMemoryPersister();
        $this->assertInstanceOf(Persister::class, $p);
        $p->set('testKey', 'testValue');
        $this->assertEquals('testValue', $p->get('testKey'));
    }

    public function testAdd()
    {
        $p = new InMemoryPersister();
        $this->assertTrue($p->add('testKey', 'testValue'));
        $this->assertEquals('testValue', $p->get('testKey'));
        $this->assertFalse($p->add('testKey', 'testValue'));
    }
}