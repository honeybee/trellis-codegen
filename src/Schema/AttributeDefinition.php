<?php

namespace Trellis\Codegen\Schema;

class AttributeDefinition
{
    protected $name;

    protected $implementor;

    protected $description;

    protected $short_name;

    protected $options;

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

    public function getImplementor()
    {
        return $this->implementor;
    }

    public function getShortName()
    {
        return $this->short_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
