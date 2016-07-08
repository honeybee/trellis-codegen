<?php

namespace Trellis\Codegen\Tests\Parser\Schema;

use Trellis\Codegen\Parser\Schema\EntityTypeSchemaXmlParser;
use Trellis\Codegen\Schema\EntityTypeSchema;
use Trellis\Codegen\Tests\TestCase;

class EntityTypeSchemaXmlParserTest extends TestCase
{
    public function testParseSchema()
    {
        $parser = new EntityTypeSchemaXmlParser;
        $type_schema = $parser->parse(__DIR__.'/Fixtures/extensive_type_schema.xml');

        $this->assertInstanceOf(EntityTypeSchema::CLASS, $type_schema);
    }
}
