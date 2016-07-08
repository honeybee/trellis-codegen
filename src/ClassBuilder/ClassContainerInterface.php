<?php

namespace Trellis\Codegen\ClassBuilder;

interface ClassContainerInterface
{
    public function getFilename();

    public function getNamespace();

    public function getPackage();

    public function getClassname();

    public function getSourceCode();
}
