<?php

namespace Trellis\Codegen\Parser\Schema;

use DOMElement;
use DOMXPath;
use Trellis\Codegen\Schema\AttributeDefinition;
use Trellis\Codegen\Schema\AttributeDefinitionList;
use Trellis\Exception;

class AttributeDefinitionXpathParser extends XpathParser
{
    protected $short_names;

    public function __construct(array $short_names = [])
    {
        $this->short_names = [];
    }

    protected function parseXpath(DOMXPath $xpath, DOMElement $context)
    {
        $attribute_list = new AttributeDefinitionList;
        foreach ($xpath->query('./attribute', $context) as $element) {
            $attribute_list = $attribute_list->push($this->parseAttribute($xpath, $element));
        }

        return $attribute_list;
    }

    protected function parseAttribute(DOMXPath $xpath, DOMElement $element)
    {
        $description = '';
        $type = $element->getAttribute('type');
        $implementor = $this->resolveImplementor($type);
        $description_element = $xpath->query('./description', $element)->item(0);

        if ($description_element) {
            $description = $this->parseDescription($xpath, $description_element);
        }

        return new AttributeDefinition([
            'name' => $element->getAttribute('name'),
            'short_name' => ($implementor == $type) ? null : $type,
            'implementor' => $implementor,
            'description' => $description,
            'options' => $this->parseOptions($xpath, $element)
        ]);
    }

    protected function resolveImplementor($type)
    {
        if (isset($this->short_names[$type])) {
            return $this->short_names[$type];
        }
        // @todo allow to register a custom shortname map to extend the core definitions.
        $core_attribute_implementor = sprintf(
            '\\Trellis\\EntityType\\Attribute\\%1$s\\%1$sAttribute',
            preg_replace_callback(
                '/(?:^|-)(.?)/',
                function ($matches) {
                    return strtoupper($matches[1]);
                },
                $type
            )
        );
        if (!class_exists($core_attribute_implementor)) {
            throw new Exception(
                sprintf('Unable to resolve given type/short-name: "%s" to an existing implementor.', $type)
            );
        }

        return $core_attribute_implementor;
    }
}
