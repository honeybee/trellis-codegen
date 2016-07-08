<?php

namespace Trellis\Codegen\Tests\Parser;

use Trellis\Codegen\Tests\TestCase;
use Trellis\Codegen\Schema\OptionDefinitionList;
use Trellis\Codegen\Schema\OptionDefinition;

class OptionDefinitionListTest extends TestCase
{
    public function testToArray()
    {
        $list = new OptionDefinitionList;

        $list->push(
            new OptionDefinition([
                'name' => 'Parent Foobar',
                'value' => new OptionDefinitionList(
                    [ new OptionDefinition([ 'value' => 'Nested Foobar One' ]) ]
                )
            ])
        );

        $expected_list_array = [ 'Parent Foobar' => [ 'Nested Foobar One' ] ];

        $this->assertSame($expected_list_array, $list->toArray());
    }
}
