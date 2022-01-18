<?php

namespace Drush\Commands;

use Consolidation\AnnotatedCommand\CommandData;
use Drush\Commands\DrushCommands;

/**
 * A drush command file to define certain policies.
 */
class PolicyCommands extends DrushCommands {

  const DANGEROUS_ENV = ['dev', 'prod', 'live', 'stg', 'stage'];

  /**
   * @hook validate sql:sync
   */
  public function validate(CommandData $commandData) {
    $target = $commandData->input()->getArgument('target');
    $env = explode('.', $target)[1];
    foreach (self::DANGEROUS_ENV as $dangerous_env) {
      if (strpos($env, $dangerous_env) !== FALSE) {
        $this->io()->writeln('You are about to do a dangerous operation on the env: ' . $env);
        $answer = $this->io()->ask('Write "I Understand" to continue...');
        if ($answer !== 'I Understand') {
          $this->io()->error('Wrong answer!');
          $this->validate($commandData);
        }
      }
    }
  }

  /**
   * @hook validate core:rsync
   */
  public function validateRsync(CommandData $commandData) {
    $target_folder = $commandData->input()->getArgument('target');
    $target = explode(':', $target_folder)[0];
    $env = explode('.', $target)[1];
    foreach (self::DANGEROUS_ENV as $dangerous_env) {
      if (strpos($env, $dangerous_env) !== FALSE) {
        $this->io()->writeln('You are about to do a dangerous operation on the env: ' . $env);
        $answer = $this->io()->ask('Write "I Understand" to continue...');
        if ($answer !== 'I Understand') {
          $this->io()->error('Wrong answer!');
          $this->validate($commandData);
        }
      }
    }
  }

  /**
   *
   * <div class=""></div>
   * @hook validate sql:drop
   */
  public function validateSqlDrop(CommandData $commandData) {
    $root = $GLOBALS["ROOT"];
    $project_name = array_pop(explode('/', $root));
    $filename = $project_name . time() . '.sql';
    $this->io()->writeln('Creating a backup first...');
    shell_exec('drush cr'); 
    shell_exec('drush sql-dump > /tmp/' . $filename);
    shell_exec('gzip /tmp/' . $filename);
    $this->io()->writeln('A backup has been created in /tmp/' . $filename . '.gz');
  }

}
