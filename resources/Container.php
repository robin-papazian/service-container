<?php

namespace Robin\Resources;

require_once './resources/SharedService.php';

use ReflectionClass;
use Robin\Resources\SharedService;

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

        $service = $this->services[$name];

        if ($service instanceof SharedService) {

            $sharedService = $service->sharedService;

            if (is_callable($sharedService)) {
                $sharedService = $sharedService($this);
            }

            $this->register($name, $sharedService);

            return $sharedService;
        }

        if (is_callable($service)) {
            return $service($this);
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

    public function registerShared($name, $sharedService)
    {
        $this->register($name, new SharedService($name, $sharedService));
    }
}
