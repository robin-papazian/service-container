<?php

namespace Service;

use Service\ServiceNoConstructor;

class ServiceWithOneDependency
{
    private $serviceNoConstructor;

    public function __construct(ServiceNoConstructor $serviceNoConstructor)
    {
        $this->serviceNoConstructor = $serviceNoConstructor;
    }
}
