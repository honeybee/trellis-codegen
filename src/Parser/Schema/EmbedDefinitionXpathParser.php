<?php

namespace Trellis\Codegen\Parser\Schema;

use Trellis\Codegen\Schema\EntityTypeDefinitionList;
use Trellis\Codegen\Schema\EmbedDefinition;
use DOMXPath;
use DOMElement;

class EmbedDefinitionXpathParser extends EntityTypeDefinitionXpathParser
{
    protected function parseXpath(DOMXPath $xpath, DOMElement $context)
    {
        $embed_definitions_list = new EntityTypeDefinitionList();
        $node_list = $xpath->query('//embed_definition', $context);

        foreach ($node_list as $element) {
            $embed_type_data = $this->parseEntityTypeDefinition($xpath, $element);
            $embed_definition = new EmbedDefinition($embed_type_data);
            $embed_definitions_list = $embed_definitions_list->push($embed_definition);
        }

        return $embed_definitions_list;
    }
}
