<?php

namespace Trellis\Codegen\Schema;

class OptionDefinition
{
    protected $name;

    protected $value;

    protected $default;

    public function __construct(array $state)
    {
        foreach ($state as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getDefault()
    {
        return $this->default;
    }
}
