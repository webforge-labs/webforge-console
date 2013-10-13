<?php

namespace Webforge\Console;

use Webforge\Common\System\File;
use Symfony\Component\Console\Tester\CommandTester;

class CommandsIncluderTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    $this->chainClass = __NAMESPACE__ . '\\CommandsIncluder';
    parent::setUp();

    $this->commandsFile = $this->getTestDirectory()->getFile('inc.commands.php');
    $this->includer = new CommandsIncluder($this->commandsFile);
  }

  public function testIncludeCanReadSomeCommands() {
    $this->assertContainsOnlyInstancesOf('Symfony\Component\Console\Command\Command', $commands = $this->includer->getCommands());
    $this->assertCount(1, $commands);

    $apiTest = $commands[0];

    $this->assertEquals('test:api', $apiTest->getName());
    $this->assertTrue($apiTest->getDefinition()->hasArgument('firstArgument'));

    $tester = new CommandTester($apiTest);

    $this->assertSame(0, $tester->execute(
      array('firstArgument'=>'arg1v')
    ));
  }

  public function testNonExistingFileDoesNotFail() {
    $include = new CommandsIncluder(new File(__DIR__.DIRECTORY_SEPARATOR.'does-not-exist.php'));
  }

  public function testDefinesAnClosureAPI() {
    $api = $this->includer->buildArgsAPI();

    extract($api);

    $this->assertInstanceOf('Closure', $arg);
    $this->assertInstanceOf('Closure', $flag);
    $this->assertInstanceOf('Closure', $opt);
  }
}
