<?php

namespace Trellis\Codegen\ClassBuilder;

class ClassContainer implements ClassContainerInterface
{
    protected $file_name;

    protected $namespace;

    protected $package;

    protected $class_name;

    protected $source_code;

    public function __construct(array $state)
    {
        foreach ($state as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }

    public function getFileName()
    {
        return $this->file_name;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function getPackage()
    {
        return $this->package;
    }

    public function getClassName()
    {
        return $this->class_name;
    }

    public function getSourceCode()
    {
        return $this->source_code;
    }

    protected function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }
}
