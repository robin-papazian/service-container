<?php

namespace Robin\Tests\Unit\Resources;

require_once __DIR__ . './../../../resources/Container.php';

use Robin\Resources\Container;
use PHPUnit\Framework\TestCase;


class ContainerTest extends TestCase
{
    public function testInstantiable()
    {
        $this->assertNotNull(new Container);
    }

    public function testRegistered()
    {
        $container = new Container;
        $container->register('foo', 'this is foo');
        $this->assertTrue($container->registered('foo'));
    }

    public function testGet()
    {
        $container = new Container;
        $container->register('foo', 'this is foo');
        $this->assertEquals('this is foo', $container->getService('foo'));
    }
}
