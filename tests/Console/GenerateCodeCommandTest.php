<?php

namespace Trellis\Codegen\Tests\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Trellis\Codegen\Config;
use Trellis\Codegen\Console\GenerateCodeCommand;
use Trellis\Codegen\Parser\ParserInterface;
use Trellis\Codegen\Service;
use Trellis\Codegen\Tests\TestCase;

class GenerateCodeCommandTest extends TestCase
{
    const FIXTURE_CONFIG = 'deploy_copy.ini';

    const FIXTURE_CONFIG_MOVE_DEPLOYMENT = 'deploy_move.ini';

    const FIXTURE_SCHEMA = 'type_schema.xml';

    protected $application;

    protected $command;

    protected $fixtures_dir;

    protected $service_mock;

    public function testValidConfigHandling()
    {
        $this->service_mock->expects($this->once())->method('generate');
        $this->service_mock->expects($this->never())->method('deploy');

        $this->command->setService($this->service_mock);

        $this->executeCommand([
            'action' => 'generate',
            '--config' => $this->fixtures_dir . self::FIXTURE_CONFIG,
            '--schema' => $this->fixtures_dir . self::FIXTURE_SCHEMA
        ]);
    }

    public function testGenerateAction()
    {
        $this->service_mock->expects($this->once())->method('generate');
        $this->service_mock->expects($this->never())->method('deploy');
        $this->command->setService($this->service_mock);

        $this->executeCommand([
            'action' => 'generate',
            '--config' => $this->fixtures_dir . self::FIXTURE_CONFIG,
            '--schema' => $this->fixtures_dir . self::FIXTURE_SCHEMA
        ]);
    }

    public function testDeployAction()
    {
        $this->service_mock->expects($this->once())->method('generate');
        $this->service_mock->expects($this->once())->method('deploy');
        $this->command->setService($this->service_mock);

        $this->executeCommand([
            'action' => 'generate+deploy',
            '--config' => $this->fixtures_dir . self::FIXTURE_CONFIG,
            '--schema' => $this->fixtures_dir . self::FIXTURE_SCHEMA
        ]);
    }

    /**
     * @expectedException \Trellis\Exception
     */
    public function testInvalidAction()
    {
        $this->service_mock->expects($this->never())->method('generate');
        $this->service_mock->expects($this->never())->method('deploy');

        $this->command->setService($this->service_mock);

        $this->executeCommand([
            'action' => 'invalid_action',
            '--config' => $this->fixtures_dir . self::FIXTURE_CONFIG,
            '--schema' => $this->fixtures_dir . self::FIXTURE_SCHEMA
        ]);
    } // @codeCoverageIgnore

    protected function setUp()
    {
        $this->fixtures_dir = __DIR__ . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;

        $this->application = new Application();
        $this->application->add(new GenerateCodeCommand());
        $this->command = $this->application->find('generate_code');

        $this->service_mock = $this->getMockBuilder(Service::CLASS)
            ->setConstructorArgs([
                'config' => $this->getMockBuilder(Config::CLASS)->setConstructorArgs([ 'config' => [] ])->getMock(),
                'schema_parser' => $this->getMockBuilder(ParserInterface::CLASS)->getMock()
            ])
            ->getMock();
    }

    protected function executeCommand(array $options = [])
    {
        $tester = new CommandTester($this->command);

        $tester->execute(
            array_merge(
                [ 'command' => $this->command->getName() ],
                $options
            )
        );

        return $tester->getDisplay();
    }
}
