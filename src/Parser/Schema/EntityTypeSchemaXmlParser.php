<?php

namespace Trellis\Codegen\Parser\Schema;

use Trellis\Codegen\Parser\ParserInterface;
use Trellis\Codegen\Schema\EntityTypeSchema;
use Trellis\Exception;

class EntityTypeSchemaXmlParser implements ParserInterface
{
    const BASE_DOCUMENT = '\Trellis\Runtime\Entity\Entity';

    protected $xsd_schema_file;

    public function __construct()
    {
        $config_dir = dirname(dirname(dirname(__DIR__)));
        $path_parts = [ $config_dir, 'config', 'schema.xsd' ];
        $this->xsd_schema_file = implode(DIRECTORY_SEPARATOR, $path_parts);
    }

    public function parse($schema_path, array $options = [])
    {
        $document = $this->createDomDocument($schema_path);
        $schema_root = $document->documentElement;
        $xpath = new Xpath($document);

        $type_definition_parser = new EntityTypeDefinitionXpathParser();
        $embed_types_parser = new EmbedDefinitionXpathParser();
        $references_parser = new ReferenceDefinitionXpathParser();
        $parse_options = [ 'context' => $schema_root ];

        $self_uri = $schema_path;
        if (0 !== mb_strpos($schema_path, 'file://')) {
            $self_uri = 'file://' . $schema_path;
        }
        return new EntityTypeSchema([
            'self_uri' => $self_uri,
            'namespace' => $schema_root->getAttribute('namespace'),
            'type_definition' => $type_definition_parser->parse($xpath, $parse_options),
            'embed_definitions' => $embed_types_parser->parse($xpath, $parse_options),
            'reference_definitions' => $references_parser->parse($xpath, $parse_options)
        ]);
    }

    protected function createDomDocument($type_schema_file)
    {
        if (!is_readable($type_schema_file)) {
            throw new Exception("Unable to read file at path '$type_schema_file'.");
        }
        // @todo more xml error handling
        $document = new Document('1.0', 'utf-8');
        if (!$document->load($type_schema_file)) {
            throw new Exception("Failed loading the given type-schema.");
        }

        $document->xinclude();
        if (!$document->schemaValidate($this->xsd_schema_file)) {
            throw new Exception("Schema validation for the given type-schema failed.");
        }

        return $document;
    }
}
