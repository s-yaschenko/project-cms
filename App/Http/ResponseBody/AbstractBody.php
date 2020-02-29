<?php


namespace App\Http\ResponseBody;


abstract class AbstractBody
{
    protected $value;

    public function __construct($value)
    {
        $this->set($value);
    }

    public function set($value)
    {
        $this->value = $value;
    }

    abstract public function __toString(): string;
}