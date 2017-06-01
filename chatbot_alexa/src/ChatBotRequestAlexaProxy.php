<?php

namespace Drupal\chatbot_alexa;

use Alexa\Request\IntentRequest;
use Drupal\chatbot_api\ChatbotRequestInterface;

/**
 * Proxy wrapping Alexa Request in a ChatbotRequestInterface.
 *
 * @package Drupal\chatbot_alexa
 */
class ChatbotRequestAlexaProxy implements ChatbotRequestInterface {

  /**
   * Original object.
   *
   * @var \Alexa\Request\IntentRequest
   */
  protected $original;

  /**
   * ChatbotRequestAlexaProxy constructor.
   *
   * @param \Alexa\Request\IntentRequest $original
   *   Original request instance.
   */
  public function __construct(IntentRequest $original) {
    $this->original = $original;
  }

  /**
   * Proxy-er calling original request methods.
   *
   * @param string $method
   *   The name of the method being called.
   * @param array $args
   *   Array of arguments passed to the method.
   */
  public function __call($method, $args) {
    call_user_func_array(array($this->original, $method), $args);
  }

  /**
   * {@inheritdoc}
   */
  public function getChatbotAttribute($name, $default = NULL) {
    $this->original->session->getAttribute($name, $default);
  }

  /**
   * {@inheritdoc}
   */
  public function getChatbotSlot($name, $default = NULL) {
    $this->original->getSlot($name, $default);
  }

}
