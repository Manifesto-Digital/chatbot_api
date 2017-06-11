<?php

namespace Drupal\chatbot_api\Command\Generate;

use Drupal\chatbot_api\Generator\PluginChatbotIntentGenerator;
use Drupal\Console\Command\Shared\ConfirmationTrait;
use Drupal\Console\Command\Shared\ModuleTrait;
use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\Console\Core\Utils\ChainQueue;
use Drupal\Console\Core\Utils\StringConverter;
use Drupal\Console\Extension\Manager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class PluginChatbotIntentCommand.
 *
 * @package Drupal\chatbot_api\Command\Generate
 *
 * @DrupalCommand (
 *     extension="chatbot_api",
 *     extensionType="module"
 * )
 */
class PluginChatbotIntentCommand extends Command {

  use ModuleTrait;
  use ConfirmationTrait;
  use CommandTrait;
  /**
   * @var \Drupal\Console\Extension\Manager
   */
  protected $extensionManager;

  /**
   * @var \Drupal\chatbot_api\Generator\PluginChatbotIntentGenerator
   */
  protected $generator;

  /**
   * @var \Drupal\Console\Core\Utils\StringConverter
   */
  protected $stringConverter;

  /**
   * @var \Drupal\Console\Core\Utils\ChainQueue
   */
  protected $chainQueue;


  /**
   * PluginFieldTypeCommand constructor.
   *
   * @param Manager                  $extensionManager
   * @param PluginChatbotIntentGenerator $generator
   * @param StringConverter          $stringConverter
   * @param ChainQueue               $chainQueue
   */
  public function __construct(Manager $extensionManager, PluginChatbotIntentGenerator $generator, StringConverter $stringConverter, ChainQueue $chainQueue) {
    $this->extensionManager = $extensionManager;
    $this->generator = $generator;
    $this->stringConverter = $stringConverter;
    $this->chainQueue = $chainQueue;
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('generate:plugin:chatbotintent')
      ->setDescription($this->trans('commands.generate.plugin.chatbotintent.description'))
      ->addOption('module', null, InputOption::VALUE_REQUIRED, $this->trans('commands.common.options.module'))
      ->addOption(
        'class',
        null,
        InputOption::VALUE_REQUIRED,
        $this->trans('commands.generate.plugin.chatbotintent.options.class')
      )
      ->addOption(
        'label',
        null,
        InputOption::VALUE_OPTIONAL,
        $this->trans('commands.generate.plugin.chatbotintent.options.label')
      )
      ->addOption(
        'plugin-id',
        null,
        InputOption::VALUE_OPTIONAL,
        $this->trans('commands.generate.plugin.chatbotintent.options.plugin-id')
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    // @see use Drupal\Console\Command\Shared\ConfirmationTrait::confirmGeneration
    if (!$this->confirmGeneration($io)) {
      return 1;
    }

    $module = $input->getOption('module');
    $class_name = $input->getOption('class');
    $label = $input->getOption('label');
    $plugin_id = $input->getOption('plugin-id');

    $this->generator
      ->generate($module, $class_name, $label, $plugin_id);

    $this->chainQueue->addCommand('cache:rebuild', ['cache' => 'discovery'], false);

    $io->info($this->trans('commands.generate.plugin.chatbotintent.messages.success'));

    return 0;
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    // --module option
    $module = $input->getOption('module');
    if (!$module) {
      // @see Drupal\Console\Command\Shared\ModuleTrait::moduleQuestion
      $module = $this->moduleQuestion($io);
      $input->setOption('module', $module);
    }

    // --class option
    $class_name = $input->getOption('class');
    if (!$class_name) {
      $class_name = $io->ask(
        $this->trans('commands.generate.plugin.chatbotintent.questions.class'),
        'ExampleIntent'
      );
      $input->setOption('class', $class_name);
    }

    // --label option
    $label = $input->getOption('label');
    if (!$label) {
      $label = $io->ask(
        $this->trans('commands.generate.plugin.chatbotintent.questions.label'),
        $this->stringConverter->camelCaseToHuman($class_name)
      );
      $input->setOption('label', $label);
    }

    // --plugin-id option
    $plugin_id = $input->getOption('plugin-id');
    if (!$plugin_id) {
      $plugin_id = $io->ask(
        $this->trans('commands.generate.plugin.chatbotintent.questions.plugin-id'),
        $this->stringConverter->camelCaseToUnderscore($class_name)
      );
      $input->setOption('plugin-id', $plugin_id);
    }
  }
}
