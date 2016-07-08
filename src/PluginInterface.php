<?php

namespace Trellis\Codegen;

use Trellis\Codegen\Schema\EntityTypeSchema;

interface PluginInterface
{
    public function execute(EntityTypeSchema $schema);
}
