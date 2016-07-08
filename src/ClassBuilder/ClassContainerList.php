<?php

namespace Trellis\Codegen\ClassBuilder;

use Trellis\Collection\TypedList;
use Trellis\Collection\UniqueItemInterface;

class ClassContainerList extends TypedList implements UniqueItemInterface
{
    public function __construct(array $class_containers = [])
    {
        parent::__construct(ClassContainer::CLASS, $class_containers);
    }
}
