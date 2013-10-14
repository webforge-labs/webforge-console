<?php

namespace Webforge\Console\Command;

use Mockery as m;

class CommandAdapterTest extends \Webforge\Code\Test\Base {
  
  public function setUp() {
    $this->chainClass = __NAMESPACE__ . '\\CommandAdapter';
    parent::setUp();

    $this->system = m::mock('Webforge\Common\System\System');

    $this->command = new CommandAdapter('something', );
  }
}
