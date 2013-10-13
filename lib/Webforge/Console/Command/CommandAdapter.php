<?php

namespace Webforge\Console\Command;

use Symfony\Component\Console\Output\OutputInterface as SymfonyInput;
use Symfony\Component\Console\Input\InputInterface as SymfonyOutput;

use Webforge\Console\CommandInput;
use Webforge\Console\CommandOutput;
use Webforge\Console\CommandInteraction;
use Webforge\Common\System\System;

abstract class CommandAdapter extends \Symfony\Component\Console\Command\Command {

  protected $input;

  protected $output;

  protected $system;

  protected $interactionHelper;

  public function __construct($cliName, System $system) {
    parent::__construct($cliName);
    $this->system = $system;
  }

  protected function execute(SymfonyInput $input, SymfonyOutput $output) {
    $this->interactionHelper = new InteractionHelper($this->getHelper('dialog'), $output);
    $this->output = new SymfonyCommandOutputAdapter($output);
    $this->input = new SymfonyCommandInputAdapter($input);

    return $this->doExecute($this->input, $this->output, $this->interactionHelper, $this->system);
  }

  abstract public function doExecute(CommandInput $input, CommandOutput $output, CommandInteraction $interact, System $system);
}
