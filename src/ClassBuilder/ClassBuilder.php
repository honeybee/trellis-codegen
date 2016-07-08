<?php

namespace Trellis\Codegen\ClassBuilder;

use Trellis\Codegen\Config;
use Twig_Environment;
use Twig_Loader_Filesystem;

abstract class ClassBuilder implements ClassBuilderInterface
{
    protected $twig;

    protected $config;

    abstract protected function getImplementor();

    abstract protected function getParentImplementor();

    abstract protected function getTemplate();

    abstract protected function getRootNamespace();

    abstract protected function getPackage();

    abstract protected function getDescription();

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->twig = new Twig_Environment(new Twig_Loader_Filesystem($this->getTemplateBaseDirectories()));
    }

    public function build()
    {
        $implementor = $this->getImplementor();

        return new ClassContainer([
            'file_name' => $implementor . '.php',
            'class_name' => $implementor,
            'namespace' => $this->getRootNamespace(),
            'package' => $this->getPackage(),
            'source_code' => $this->twig->render($this->getTemplate(), $this->getTemplateVars())
        ]);
    }

    protected function getTemplateVars()
    {
        $parent_class = $this->getParentImplementor();
        $parent_class_parts = array_filter(explode('\\', $parent_class));

        return [
            'description' => $this->getDescription(),
            'namespace' => $this->getNamespace(),
            'class_name' => $this->getImplementor(),
            'parent_class_name' => array_pop($parent_class_parts),
            'parent_implementor' => trim($this->getParentImplementor(), '\\')
        ];
    }

    protected function getNamespace()
    {
        return $this->getRootNamespace();
    }

    protected function getTemplateBaseDirectories()
    {
        $tpl_directories = [];
        $custom_dir = $this->config->getTemplateDirectory(false);
        if ($custom_dir) {
            $tpl_directories[] = $custom_dir;
        }

        $tpl_directories[] = __DIR__.'/templates';

        return $tpl_directories;
    }
}
