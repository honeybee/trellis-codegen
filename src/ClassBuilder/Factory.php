<?php

namespace Trellis\Codegen\ClassBuilder;

use Trellis\Codegen\ClassBuilder\Common\BaseEntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Common\BaseEntityTypeClassBuilder;
use Trellis\Codegen\ClassBuilder\Common\EntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Common\EntityTypeClassBuilder;
use Trellis\Codegen\ClassBuilder\Embed\BaseEmbedEntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Embed\BaseEmbedTypeClassBuilder;
use Trellis\Codegen\ClassBuilder\Embed\EmbedEntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Embed\EmbedTypeClassBuilder;
use Trellis\Codegen\ClassBuilder\Reference\BaseReferenceEntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Reference\BaseReferenceTypeClassBuilder;
use Trellis\Codegen\ClassBuilder\Reference\ReferenceEntityClassBuilder;
use Trellis\Codegen\ClassBuilder\Reference\ReferenceTypeClassBuilder;
use Trellis\Codegen\Config;
use Trellis\Codegen\Schema\EmbedDefinition;
use Trellis\Codegen\Schema\EntityTypeDefinition;
use Trellis\Codegen\Schema\EntityTypeSchema;
use Trellis\Codegen\Schema\ReferenceDefinition;

class Factory
{
    protected $config;

    protected $type_schema;

    public function __construct(Config $config, EntityTypeSchema $type_schema = null)
    {
        $this->config = $config;
        $this->type_schema = $type_schema;
    }

    public function getEntityTypeSchema()
    {
        return $this->type_schema;
    }

    public function setEntityTypeSchema(EntityTypeSchema $type_schema)
    {
        $this->type_schema = $type_schema;
    }

    public function createClassBuildersForType(EntityTypeDefinition $type)
    {
        switch (get_class($type)) {
            case EmbedDefinition::CLASS:
                $class_builders = $this->createEmbedClassBuilders($type);
                break;
            case ReferenceDefinition::CLASS:
                $class_builders = $this->createReferenceClassBuilders($type);
                break;
            default:
                $class_builders = $this->createDefaultClassBuilders($type);
                break;
        }

        return $class_builders;
    }

    protected function createDefaultClassBuilders(EntityTypeDefinition $type)
    {
        $builder_properties = [ $this->config, $this->type_schema, $type ];

        return [
            new BaseEntityTypeClassBuilder(...$builder_properties),
            new EntityTypeClassBuilder(...$builder_properties),
            new BaseEntityClassBuilder(...$builder_properties),
            new EntityClassBuilder(...$builder_properties)
        ];
    }

    protected function createEmbedClassBuilders(EntityTypeDefinition $embed_type_def)
    {
        $builder_properties = [ $this->config, $this->type_schema, $embed_type_def ];

        return [
            new BaseEmbedTypeClassBuilder(...$builder_properties),
            new EmbedTypeClassBuilder(...$builder_properties),
            new BaseEmbedEntityClassBuilder(...$builder_properties),
            new EmbedEntityClassBuilder(...$builder_properties)
        ];
    }

    protected function createReferenceClassBuilders(EntityTypeDefinition $reference_type_def)
    {
        $builder_properties = [ $this->config, $this->type_schema, $reference_type_def ];

        return [
            new BaseReferenceTypeClassBuilder(...$builder_properties),
            new ReferenceTypeClassBuilder(...$builder_properties),
            new BaseReferenceEntityClassBuilder(...$builder_properties),
            new ReferenceEntityClassBuilder(...$builder_properties)
        ];
    }
}
