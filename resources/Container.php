<?php

namespace Robin\Resources;

use ReflectionClass;

class Container
{
    private array $services = [];

    private static ?Container $instance = null;

    /**
     * @param string $name
     * @param mixed $service
     * @return void
     */
    public function register(string $name, $service): void
    {
        $this->services[$name] = $service;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function registered(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    public function getService(string $name)
    {
        if (!$this->registered($name)) {

            if (class_exists($name)) {

                return $this->buildClass($name);
            }
            throw new NotRegisteredException($name);
        }

        $anonymousFunction = $this->services[$name];
        if (is_callable($anonymousFunction)) {
            return $anonymousFunction($this);
        }

        return $this->services[$name];
    }

    public static function injector(): Container
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function setInjector(Container $container): void
    {
        self::$instance = $container;
    }

    private function buildClass($name)
    {
        /**
         * @var ReflectionClass $bluePrintClass
         */
        $bluePrintClass = new \ReflectionClass($name);
        $bluePrintConstructor = $bluePrintClass->getConstructor();

        $bluePrintParameters = $bluePrintConstructor ? $bluePrintConstructor->getParameters() : [];

        return new $name(...$this->getDependencies($bluePrintParameters));
    }

    private function getDependencies(array $parameters): array
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {

            $dependencies[$parameter->getPosition()] = $this->getService($parameter->getType()->getName());
        }

        return $dependencies;
    }

    public function registerCallable($name, $callable): void
    {
        $this->register($name, function () use ($callable) {
            return $callable;
        });
    }
}
