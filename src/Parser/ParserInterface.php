<?php

namespace Trellis\Codegen\Parser;

use Trellis\Codegen\Schema\EntityTypeDefinitionList;
use Trellis\Codegen\Schema\EmbedDefinition;

interface ParserInterface
{
    /**
     * Parses the given source and returns the result.
     *
     * @return mixed
     */
    public function parse($source, array $options = []);
}
