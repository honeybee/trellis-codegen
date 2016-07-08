<?php

namespace Trellis\Codegen\Schema;

use Trellis\Collection\TypedList;
use Trellis\Collection\UniqueItemInterface;

class OptionDefinitionList extends TypedList implements UniqueItemInterface
{
    public function __construct(array $options = [])
    {
        parent::__construct(OptionDefinition::CLASS, $options);
    }

    public function filterByName($name)
    {
        $options = $this->filter(
            function ($option) use ($name) {
                return $option->getName() === $name;
            }
        );

        return count($options) > 0 ? $options[0] : null;
    }

    public function toArray()
    {
        $data = [];

        foreach ($this->items as $option) {
            $name = $option->getName();
            $value = $option->getValue();
            $next_value = $value;

            if ($value instanceof OptionDefinitionList) {
                $next_value = $value->toArray();
            }

            $next_value = $next_value ? $next_value : $option->getDefault();

            if ($name) {
                $data[$name] = $next_value;
            } else {
                $data[] = $next_value;
            }
        }

        return $data;
    }
}
