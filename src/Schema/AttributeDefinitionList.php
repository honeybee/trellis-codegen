<?php

namespace Trellis\Codegen\Schema;

use Trellis\Collection\TypedList;
use Trellis\Collection\UniqueItemInterface;

class AttributeDefinitionList extends TypedList implements UniqueItemInterface
{
    public function __construct(array $attribute_definitions = [])
    {
        parent::__construct(AttributeDefinition::CLASS, $attribute_definitions);
    }

    public function filterByType($type)
    {
        return $this->filter(
            function ($attribute) use ($type) {
                return $attribute->getShortName() === $type;
            }
        );
    }
}
