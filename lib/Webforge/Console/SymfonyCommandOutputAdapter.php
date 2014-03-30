<?php

namespace Webforge\Console;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Adapter for Symfony Output to the Weboforge\Console\CommandOutput Interface
 */
class SymfonyCommandOutputAdapter implements CommandOutput {

  protected $consoleOutput;

  public function __construct(OutputInterface $output) {
    $this->consoleOutput = $output;
  }

  /**
   * @inherit-doc
   */ 
   public function ok($msg) {
    return $this->msg('<info>'.$msg.'</info>');
  }

  /**
   * @inherit-doc
   */ 
  public function warn($msg) {
    return $this->msg('<comment>'.$msg.'</comment>');
  }

  /**
   * @inherit-doc
   */ 
  public function error($msg) {
    return $this->msg('<error>'.$msg.'</error>');
  }

  /**
   * @inherit-doc
   */ 
  public function msg($msg) {
    $this->consoleOutput->writeln($msg);
  }

  /**
   * @inherit-doc
   */ 
  public function br() {
    return $this->msg("");
  }
}
