<?php

namespace PrinterMonk\Entities;

abstract class BaseEntity
{
    protected $attributes = [];

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * Make var_dump and print_r look pretty
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->attributes;
    }

    public function __isset($name)
    {
        return (bool)(key_exists($name, $this->attributes));
    }

}