<?php

use Symfony\Component\Console\Input\InputInterface as SymfonyInput;
use Symfony\Component\Console\Output\OutputInterface as SymfonyOutput;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 *
 * $createCommand = function ($name, array|closure $configure, closure $execute, $help = NULL)
 *
 * // argument
 * $arg = function ($name, $description = NULL, $required = TRUE, $multiple = FALSE) // default: required
 *
 * // option
 * $opt = function($name, $short = NULL, $withValue = TRUE, $description = NULL) // default: mit value required
 * $flag = function($name, $short = NULL, $description) // ohne value
 */
$createCommand('test:api',
  array(
    $arg('firstArgument', 'this describes argument one'),
    $flag('some-flag', NULL, 'description of flag')
  ),
  function ($input, $output, $command) {

    if (!($input instanceof SymfonyInput)) throw new \RuntimeException('Input is not from correct class. Actual: '.get_class($input));
    if (!($output instanceof SymfonyOutput)) throw new \RuntimeException('Output is not from correct class. Actual: '.get_class($output));
    if (!($command instanceof SymfonyCommand)) throw new \RuntimeException('Command is not set correctly. Actual:'.get_class($command));

    $output->writeln('im processing nothing yet. change me in lib/inc.commands.php!');
    
    return 0;
  },
  'a brief description of the command (see lib/inc.commands.php to change chis command)'
);
