<?php

namespace Service;

use Service\ServiceWithOneDependency;
use Service\ServiceMultipleDependecies;

class ServiceWithNestedDependencies
{
    private $serviceWithOneDependency;
    private $serviceWithMultipleDependecy;

    public function __construct(ServiceWithOneDependency $serviceWithOneDependency, ServiceMultipleDependecies $serviceMultipleDependecies)
    {
        $this->serviceWithOneDependency = $serviceWithOneDependency;
        $this->serviceWithMultipleDependecy = $serviceMultipleDependecies;
    }
}
