<?php

namespace Trellis\Codegen\Schema;

use Trellis\Collection\TypedList;
use Trellis\Collection\UniqueItemInterface;

class EntityTypeDefinitionList extends TypedList implements UniqueItemInterface
{
    public function __construct(array $type_definitions = [])
    {
        parent::__construct(EntityTypeDefinition::CLASS, $type_definitions);
    }
}
