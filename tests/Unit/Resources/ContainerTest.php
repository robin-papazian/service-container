<?php

namespace Robin\Tests\Unit\Resources;

require_once __DIR__ . './../../../resources/Container.php';
require_once __DIR__ . './../../../resources/NotRegisteredException.php';
require_once __DIR__ . './../../../lib/Service/ServiceNoConstructor.php';
require_once __DIR__ . './../../../lib/Service/ServiceEmptyConstructor.php';
require_once __DIR__ . './../../../lib/Service/ServiceWithOneDependency.php';
require_once __DIR__ . './../../../lib/Service/ServiceMultipleDependecies.php';
require_once __DIR__ . './../../../lib/Service/ServiceWithNestedDependencies.php';

use Closure;
use Robin\Resources\Container;
use PHPUnit\Framework\TestCase;
use Robin\Resources\NotRegisteredException;
use Service\ServiceEmptyConstructor;
use Service\ServiceMultipleDependecies;
use Service\ServiceNoConstructor;
use Service\ServiceWithNestedDependencies;
use Service\ServiceWithOneDependency;

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

    public function testContainerAsSingleTon()
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

    /**
     * @dataProvider provideServices
     */
    public function testResolveDependenciesFromClassNotRegister($instances)
    {
        $container = new Container;
        $this->assertInstanceOf($instances, $container->getService($instances));
    }

    public function provideServices()
    {
        return [
            'no constructor' => [ServiceNoConstructor::class],
            'empty constructor' => [ServiceEmptyConstructor::class],
            'one dependency' => [ServiceWithOneDependency::class],
            'multiple depemdencies' => [ServiceMultipleDependecies::class],
            'nested dependencies' => [ServiceWithNestedDependencies::class]
        ];
    }

    /**
     * @dataProvider provideCallables
     */
    public function testRegisterCallable($callable, $callableOutPut)
    {
        $container = new Container;
        $container->registerCallable('someFunction', $callable);
        $this->assertEquals($callableOutPut, $container->getService('someFunction')());
    }

    public function provideCallables()
    {
        return [
            'anonymous_function' => [fn () => 'this is a function', 'this is a function'],
            'invokable class'    => [
                new class
                {
                    public function __invoke()
                    {
                        return 'A class That Invoke Something';
                    }
                },
                'A class That Invoke Something'
            ],
            'Closure' => [Closure::fromCallable(fn () => 'some other function'), 'some other function']
        ];
    }

    public function testRegisterShared()
    {
        $container = new Container;
        $container->registerShared(ServiceNoConstructor::class, fn () => new ServiceNoConstructor);
        $this->assertInstanceOf(ServiceNoConstructor::class, $container->getService(ServiceNoConstructor::class));
        $this->assertSame($container->getService(ServiceNoConstructor::class), $container->getService(ServiceNoConstructor::class));
    }
}
