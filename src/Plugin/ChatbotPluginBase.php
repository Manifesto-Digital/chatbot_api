<?php

namespace Drupal\chatbot_api\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Chatbot Plugin plugins.
 */
abstract class ChatbotPluginBase extends PluginBase implements ChatbotPluginInterface {

  /**
   * The response.
   *
   * @var \Drupal\chatbot_api\ChatbotResponseInterface
   */
  protected $response;

  /**
   * The response.
   *
   * @var \Drupal\chatbot_api\ChatbotRequestInterface
   */
  protected $request;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->response = $this->configuration['response'];
    $this->request = $this->configuration['request'];
  }

}
