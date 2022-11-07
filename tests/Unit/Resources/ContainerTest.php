<?php

namespace Robin\Tests\Unit\Resources;

require_once __DIR__ . './../../../resources/Container.php';
require_once __DIR__ . './../../../resources/NotRegisteredException.php';

use Robin\Resources\Container;
use PHPUnit\Framework\TestCase;
use Robin\Resources\NotRegisteredException;

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

    public function testGetService()
    {
        $container = new Container;
        $container->register('foo', 'this is foo');
        $this->assertEquals('this is foo', $container->getService('foo'));
    }

    public function testNotRegisteredException()
    {
        $this->expectException(NotRegisteredException::class);
        $this->expectExceptionMessage("`not registered` is not registered");
        $container = new Container;
        $container->getService('not registered');
    }

    public function testInjectorAsSingleTon()
    {
        $this->assertInstanceOf(Container::class, Container::injector());
        $this->assertSame(Container::injector(), Container::injector());
    }

    public function testSetInjector()
    {
        $container = new Container();
        Container::setInjector($container);
        $this->assertSame($container, Container::injector());
    }

    public function testRegisteringFunctionAsService()
    {
        $container = new Container();

        $container->register('foo', function () {

            return 'this is foo';
        });

        $this->assertEquals('this is foo', $container->getService('foo'));
    }

    public function testRegisteringItSelfAsService()
    {
        $container = new Container();

        $container->register('foo', function (?Container $injector = null) use ($container) {

            $this->assertEquals($container, $injector);
        });

        $container->getService('foo');
    }

    public function testInstanciateClassNotRegister()
    {
        $container = new Container();

        $this->assertInstanceOf(Container::class, $container->getService(Container::class));
    }
}
