<?php

namespace Service;

use Service\ServiceNoConstructor;
use Service\ServiceEmptyConstructor;

class ServiceMultipleDependecies
{
    private $serviceNoConstructor;
    private $serviceEmptyConstructor;

    public function __construct(ServiceNoConstructor $serviceNoConstructor, ServiceEmptyConstructor $serviceEmptyConstructor)
    {
        $this->serviceNoConstructor = $serviceNoConstructor;
        $this->serviceEmptyConstructor = $serviceEmptyConstructor;
    }
}
