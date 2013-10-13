<?php

namespace Webforge\Console;

class ApplicationTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    $this->chainClass = __NAMESPACE__ . '\\Application';
    parent::setUp();

    $this->app = new Application();
  }

  public function testSymfonyInterface() {
    $this->assertInstanceOf('Symfony\Component\Console\Application', $this->app);
  }
}
