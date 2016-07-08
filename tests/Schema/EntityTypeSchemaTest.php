<?php

namespace Trellis\Codegen\Tests\Parser;

use Trellis\Codegen\Tests\TestCase;
use Trellis\Codegen\Schema\EntityTypeSchema;
use Trellis\Codegen\Schema\OptionDefinition;
use Trellis\Codegen\Parser\Schema\EntityTypeSchemaXmlParser;

class EntityTypeSchemaTest extends TestCase
{
    public function testGetUsedEmbedDefinitions()
    {
        $schema_path = __DIR__ .
            DIRECTORY_SEPARATOR . 'Fixtures' .
            DIRECTORY_SEPARATOR . 'complex_schema.xml';

        $schema_parser = new EntityTypeSchemaXmlParser();
        $type_schema = $schema_parser->parse($schema_path);

        $embed_defs = $type_schema->getUsedEmbedDefinitions(
            $type_schema->getEntityTypeDefinition()
        );

        $this->assertEquals(1, $embed_defs->getSize());
    }
/* @todo readd when reference-list has landed again in trellis
    public function testGetUsedReferenceDefinitions()
    {
        $schema_path = __DIR__ .
            DIRECTORY_SEPARATOR . 'Fixtures' .
            DIRECTORY_SEPARATOR . 'complex_schema.xml';

        $schema_parser = new EntityTypeSchemaXmlParser();
        $type_schema = $schema_parser->parse($schema_path);

        $embed_defs = $type_schema->getUsedReferenceDefinitions(
            $type_schema->getEntityTypeDefinition()
        );

        $this->assertEquals(2, $embed_defs->getSize());
    }
*/
}
