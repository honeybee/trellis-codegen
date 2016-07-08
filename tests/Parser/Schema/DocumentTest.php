<?php

namespace Trellis\Codegen\Tests\Parser\Schema;

use Trellis\Codegen\Parser\Schema\Document;
use Trellis\Codegen\Parser\Schema\EntityTypeSchemaXmlParser;
use Trellis\Codegen\Parser\Schema\Xpath;
use Trellis\Codegen\Schema\EntityTypeSchema;
use Trellis\Codegen\Tests\TestCase;

class DocumentTest extends TestCase
{
    public function testGenericXinclude()
    {
        $type_schema_path = __DIR__ .
            DIRECTORY_SEPARATOR . 'Fixtures' .
            DIRECTORY_SEPARATOR . 'extensive_type_schema_include.xml';

        $document = new Document('1.0', 'utf-8');
        $document->load($type_schema_path);
        $document->xinclude();

        $xpath = new Xpath($document);
        $xml_base_nodes = $xpath->query('//@xml:base', $document);

        $this->assertEquals(0, $xml_base_nodes->length);
    }

    public function testSpecificXinclude()
    {
        $parser = new EntityTypeSchemaXmlParser();
        $type_schema = $parser->parse(__DIR__.'/Fixtures/extensive_type_schema_include.xml');

        $this->assertInstanceOf(EntityTypeSchema::CLASS, $type_schema);
    }
}
