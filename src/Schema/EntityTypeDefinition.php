<?php

namespace Trellis\Codegen\Schema;

class EntityTypeDefinition
{
    protected $name;

    protected $implementor;

    protected $entity_implementor;

    protected $description;

    protected $options;

    protected $attributes;

    public function __construct(array $state = [])
    {
        foreach ($state as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
        if (empty($this->attributes)) {
            $this->attributes = new AttributeDefinitionList;
        }
        if (empty($this->options)) {
            $this->options = new OptionDefinitionList;
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

    public function getEntityImplementor()
    {
        return $this->entity_implementor;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}
