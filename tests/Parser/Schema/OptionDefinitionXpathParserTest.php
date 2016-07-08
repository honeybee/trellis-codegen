<?php

namespace Trellis\Codegen\Tests\Parser\Schema;

use Trellis\Codegen\Parser\Schema\Document;
use Trellis\Codegen\Parser\Schema\OptionDefinitionXpathParser;
use Trellis\Codegen\Parser\Schema\Xpath;
use Trellis\Codegen\Schema\OptionDefinitionList;
use Trellis\Codegen\Tests\TestCase;

class OptionDefinitionXpathParserTest extends TestCase
{
    public function testOneNestedOptions()
    {
        $dom_document = new Document('1.0', 'utf-8');
        $dom_document->loadXML(
            '<random_container xmlns="http://berlinonline.net/trellis/1.0/schema">
                <option name="types">
                    <option>VotingStats</option>
                </option>
            </random_container>'
        );

        $xpath = new Xpath($dom_document);
        $parser = new OptionDefinitionXpathParser;
        $option_definitions = $parser->parse($xpath, [ 'context' => $dom_document->documentElement ]);
        $this->assertInstanceOf(OptionDefinitionList::CLASS, $option_definitions);

        $types_option = $option_definitions[0];
        $types_options_value = $types_option->getValue();
        $this->assertEquals(1, $option_definitions->getSize());
        $this->assertEquals('VotingStats', $types_options_value[0]->getValue());
    }
}
