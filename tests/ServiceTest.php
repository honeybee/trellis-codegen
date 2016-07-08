<?php

namespace Trellis\Codegen\Tests;

use Symfony\Component\Filesystem\Filesystem;
use Trellis\Codegen\Config;
use Trellis\Codegen\Parser\Schema\EntityTypeSchemaXmlParser;
use Trellis\Codegen\Service;
use Trellis\Codegen\Tests\TestCase;

class ServiceTest extends TestCase
{
    protected $config;

    protected $schema_path;

    public function testBuildSchema()
    {
        $codegen_service = new Service($this->config, new EntityTypeSchemaXmlParser);
        $codegen_service->generate($this->schema_path);
        // @todo assert validity of the generated code inside the configured cache directory.
    }

    public function testDeployMethodMove()
    {
        $this->config->setDeployMethod('move');

        $codegen_service = new Service($this->config, new EntityTypeSchemaXmlParser);
        $codegen_service->generate($this->schema_path);
        $codegen_service->deploy($this->schema_path);
        // @todo assert validity of the generated code inside the configured deploy directory.
    }

    public function testDeployMethodCopy()
    {
        $this->config->setDeployMethod('copy');

        $codegen_service = new Service($this->config, new EntityTypeSchemaXmlParser);
        $codegen_service->generate($this->schema_path);
        $codegen_service->deploy($this->schema_path);
        // @todo assert validity of the generated code inside the configured deploy directory.
    }

    protected function setUp()
    {
        $tmp_dir = sys_get_temp_dir().'/';
        $tmp_cache_path = $tmp_dir.'testing_cache_' . mt_rand().'/';
        $tmp_deploy_path = $tmp_dir.'testing_deploy_' . mt_rand().'/';

        $this->config = new Config([
            'cache_dir' => $tmp_cache_path,
            'deploy_dir' => $tmp_deploy_path,
            'plugin_settings' => []
        ]);

        $this->schema_path = __DIR__.'/Fixtures/complex_schema.xml';
    }

    protected function tearDown()
    {
        $filesystem = new Filesystem;
        $filesystem->remove($this->config->getCacheDir());
        $filesystem->remove($this->config->getDeployDir());
    }
}
