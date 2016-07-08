<?php

namespace Trellis\Codegen\ClassBuilder\Common;

use Trellis\Codegen\ClassBuilder\ClassBuilder as BaseClassBuilder;
use Trellis\Codegen\Config;
use Trellis\Codegen\Schema\EntityTypeDefinition;
use Trellis\Codegen\Schema\EntityTypeSchema;

abstract class ClassBuilder extends BaseClassBuilder
{
    const NS_FIELDS = '\\Trellis\\Runtime\\Attribute\\Type';

    const NS_MODULE = '\\Trellis\\Runtime';

    const NS_ENTITY = '\\Trellis\\Runtime\\Entity';

    protected $type_schema;

    protected $type_definition;

    public function __construct(Config $config, EntityTypeSchema $type_schema, EntityTypeDefinition $type_definition)
    {
        parent::__construct($config);

        $this->type_schema = $type_schema;
        $this->type_definition = $type_definition;
    }

    protected function getDescription()
    {
        return $this->type_definition->getDescription();
    }

    protected function getRootNamespace()
    {
        return $this->type_schema->getNamespace();
    }

    protected function getPackage()
    {
        return $this->type_schema->getPackage();
    }

    protected function getImplementor()
    {
        $class_suffix = $this->config->getTypeSuffix('Type');

        return $this->type_definition->getName() . ucfirst($class_suffix);
    }

    protected function getParentImplementor()
    {
        return sprintf('\\%s\\Base\\%s', $this->getNamespace(), $this->getImplementor());
    }

    protected function getTemplateVars()
    {
        $basic_class_vars = array(
            'type_name' => $this->type_definition->getName()
        );

        return array_merge(parent::getTemplateVars(), $basic_class_vars);
    }
}
