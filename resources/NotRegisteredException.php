<?php

namespace Robin\Resources;

use RuntimeException;

class NotRegisteredException extends \RuntimeException
{
    public function __construct($name)
    {
        $message = sprintf("`%s` is not registered", $name);
        parent::__construct($message);
    }
}
