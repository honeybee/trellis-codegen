<?php

namespace Trellis\Codegen\Tests;

use Trellis\Codegen\Tests\TestCase;
use Trellis\Codegen\Config;

class ConfigTest extends TestCase
{
    const FIX_CACHE_DIR = '/tmp/trellis_test_cache';

    const FIX_DEPLOY_DIR = '/tmp/trellis_test_deploy';

    public function testCreateConfig()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'copy'
        ]);

        $this->assertInstanceOf('Trellis\Codegen\Config', $config->validate());
    }

    public function testConfigGetCacheDir()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'copy'
        ]);

        $this->assertEquals(self::FIX_CACHE_DIR, $config->validate()->getCacheDir());
    }

    public function testConfigGetDeployDir()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'copy'
        ]);
        $this->assertEquals(self::FIX_DEPLOY_DIR, $config->validate()->getDeployDir());
    }

    public function testConfigGetDefaultDeployMethod()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR
        ]);

        $this->assertEquals('copy', $config->validate()->getDeployMethod());
    }

    public function testConfigGetDeployMethod()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'move'
        ]);
        $this->assertEquals('move', $config->validate()->getDeployMethod());
    }

    public function testConfigGetPluginSettings()
    {
        $plugin_settings = [];

        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'copy',
            'plugin_settings' => $plugin_settings
        ]);
        $this->assertEquals($plugin_settings, $config->validate()->getPluginSettings());
    }

    public function testValidateCorrectData()
    {
        $config = new Config([
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR,
            'deploy_method' => 'copy'
        ]);
        // test fluent api, as $this is returned on success
        $this->assertInstanceOf('Trellis\Codegen\Config', $config->validate());
    }

    /**
     * @expectedException \Trellis\Exception
     */
    public function testValidateMissingCacheDir()
    {
        $config = new Config(
            [ 'deploy_dir' => self::FIX_DEPLOY_DIR ]
        );
        $config->validate();
    } // @codeCoverageIgnore


    /**
     * @expectedException \Trellis\Exception
     */
    public function testValidateMissingDeployDir()
    {
        $config = new Config(
            [ 'cache_dir' => self::FIX_CACHE_DIR ]
        );
        $config->validate();
    } // @codeCoverageIgnore

    /**
     * @expectedException \Trellis\Exception
     */
    public function testCreateWithInvalidDeployMethod()
    {
        $config = new Config([
            'deploy_method' => 'invalid_deploy_method',
            'cache_dir' => self::FIX_CACHE_DIR,
            'deploy_dir' => self::FIX_DEPLOY_DIR
        ]);
        $config->validate();
    } // @codeCoverageIgnore
}
