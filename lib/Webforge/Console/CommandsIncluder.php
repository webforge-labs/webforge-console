<?php

namespace Webforge\Console;

use Webforge\Common\System\File;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Closure;

/**
 *
 * $createCommand = function ($name, array|closure $configure, closure $execute, $help = NULL)
 * 
 * $arg = function ($name, $description = NULL, $required = TRUE, $multiple = FALSE) // default: required
 * $opt = function($name, $short = NULL, $withValue = TRUE, $description = NULL) // default: mit value required
 * $defOpt = function($name, $short = NULL, $default = NULL, $description = NULL) // with value and a default value
 * $flag = function($name, $short = NULL, $description) // ohne value
 */
class CommandsIncluder {

  protected $includedCommands;
  protected $file;
  protected $scope;

  public function __construct(File $file, Array $scope = array()) {
    $this->file = $file;
    $this->scope = $scope;
  }
  
  public function getCommands() {
    if (!isset($this->includedCommands)) {
      $commands = array();
      if ($this->file->exists()) {

        $createCommand = function ($name, Array $definition, Closure $execute, $description = NULL) use (&$commands) {
          $command = new Command($name);
          $command->setDefinition($definition);
          $command->setCode(function($input, $output) use ($execute, $command) {
            return $execute($input, $output, $command);
          });

          $commands[] = $command;

          if (isset($description))
            $command->setDescription($description);
            
          return $command;
        };

        extract($this->buildArgsAPI());
        extract($this->scope);
        
        require $this->file;
      }
      
      
      if (isset($commands) && is_array($commands)) {
        $this->includedCommands = array_filter($commands, function ($command) {
          return $command instanceof Command;
        });
      } else {
        $this->includedCommands = array();
      }
    }
    
    return $this->includedCommands;
  }

  public function buildArgsAPI() {
    $arg = function ($name, $description = NULL, $required = TRUE, $multiple = FALSE) {
      $mode = $required ? InputArgument::REQUIRED : InputArgument::OPTIONAL;
      if ($multiple) {
        $mode |= InputArgument::IS_ARRAY;
      }
      return new InputArgument($name, $mode, $description);
    };
    
    $args = function ($name, $description = NULL, $required = TRUE) use ($arg) {
      return $arg($name, $description, $required, TRUE);
    };

    $opt = function ($name, $short = NULL, $withValue = TRUE, $description = NULL, $default = NULL) {
      return new InputOption($name, $short, $withValue ? InputOption::VALUE_REQUIRED : InputOption::VALUE_OPTIONAL, $description, $default);
    };

    $defOpt = function ($name, $short = NULL, $default = NULL, $description = NULL) {
      return new InputOption($name, $short, InputOption::VALUE_REQUIRED, $description, $default);
    };

    $flag = function ($name, $short = NULL, $description = NULL) {
      return new InputOption($name, $short, InputOption::VALUE_NONE, $description);
    };

    return compact('arg', 'args', 'opt', 'defOpt', 'flag');
  }
}
