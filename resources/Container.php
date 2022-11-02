<?php

namespace Robin\Resources;


class Container
{
    private array $services = [];

    public function register(string $name, string $service): void
    {
        $this->services[$name] = $service;
    }

    public function registered(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    public function getService(string $name)
    {
        if (!$this->registered($name)) {
            throw new NotRegisteredException($name);
        }
        return $this->services[$name];
    }
}
