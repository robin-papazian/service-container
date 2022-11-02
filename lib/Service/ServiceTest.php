<?php

class ServiceTest
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function test()
    {
        var_dump($this);
        var_dump(self::class);
    }
}
