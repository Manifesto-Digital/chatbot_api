<?php

namespace Drupal\chatbot_api\Plugin\views\display;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The plugin that handles a Chatbot Intent views iterator.
 *
 * @ingroup views_display_plugins
 *
 * @ViewsDisplay(
 *   id = "chatbot_intent",
 *   title = @Translation("Chatbot Intent"),
 *   help = @Translation("Expose the view as Chatbot API Intent."),
 *   theme = "views_view",
 *   register_theme = FALSE,
 *   admin = @Translation("Chatbot Intent")
 * )
 *
 * @see \Drupal\chatbot_api\Plugin\Chatbot\Intent\ViewsIntent
 * @see \Drupal\chatbot_api\Plugin\Derivative\ViewsIntent
 */
class ChatbotIntent extends DisplayPluginBase {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The Chatbot Intent plugins manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $intentManager;

  /**
   * {@inheritdoc}
   */
  protected $usesAJAX = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $usesPager = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $usesMore = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $usesAreas = FALSE;

  /**
   * {@inheritdoc}
   */
  protected $usesOptions = FALSE;

  /**
   * Constructs a new ChatbotIntent instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Component\Plugin\PluginManagerInterface $chatbot_intent_manager
   *   The Chatbot Intent plugins manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityManagerInterface $entity_manager, PluginManagerInterface $chatbot_intent_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->entityManager = $entity_manager;
    $this->intentManager = $chatbot_intent_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager'),
      $container->get('plugin.manager.chatbot_intent_plugin')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function usesExposed() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function displaysExposed() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    // Options for REST authentication.
    $options['intent_name'] = ['default' => ''];

    unset($options['exposed_form']);
    unset($options['exposed_block']);
    unset($options['css_class']);

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function optionsSummary(&$categories, &$options) {
    parent::optionsSummary($categories, $options);

    unset($categories['page'], $categories['exposed'], $categories['title']);
    // Hide some settings, as they aren't useful for pure data output.
    unset($options['show_admin_links'], $options['analyze-theme']);

    $categories['intent'] = [
      'title' => $this->t('Intent settings'),
      'column' => 'first',
      'build' => [
        '#weight' => -10,
      ],
    ];

    $options['intent_name'] = [
      'category' => 'intent',
      'title' => $this->t('Intent name'),
      'value' => $this->getOption('intent_name') ?: $this->t('No Intent name is set'),
    ];

    // Remove css/exposed form settings, as they are not used for the data
    // display.
    unset($options['exposed_form']);
    unset($options['exposed_block']);
    unset($options['css_class']);
  }

  /**
   * The display block handler returns the structure necessary for a block.
   */
  public function execute() {
    parent::execute();

    return $this->view->render();
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    if ($form_state->get('section') === 'intent_name') {
      $form['#title'] .= $this->t('The Intent Name this view handles.');
      $form['intent_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Intent Name'),
        '#description' => $this->t('This is the Intent Name this view should handle. Intent names are case sensitive.'),
        '#default_value' => $this->getOption('intent_name'),
        '#required' => TRUE,
      ];
    }
  }

  public function validateOptionsForm(&$form, FormStateInterface $form_state) {
    parent::validateOptionsForm($form, $form_state);

    // Avoid duplicated Intents.
    if ($form_state->get('section') === 'intent_name' && $intent_name = $form_state->getValue('intent_name')) {
      if ($this->intentManager->hasDefinition($intent_name)) {
        $form_state->setError($form['intent_name'], 'Intent ' . $intent_name . ' already exists.');
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitOptionsForm(&$form, FormStateInterface $form_state) {
    parent::submitOptionsForm($form, $form_state);

    if ($form_state->get('section') == 'intent_name') {
      $this->setOption('intent_name', $form_state->getValue('intent_name'));
    }
  }

}
