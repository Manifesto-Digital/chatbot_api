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
   *
   * @return mixed
   *   The value returned from the called method.
   */
  public function __call($method, $args) {
    return call_user_func_array(array($this->original, $method), $args);
  }

  /**
   * Proxy-er calling original request properties.
   *
   * @param string $name
   *   The name of the property to get.
   *
   * @return mixed
   *   The value of the property, NULL otherwise.
   */
  public function __get($name) {
    if (isset($this->original->{$name})) {
      return $this->original->{$name};
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getChatbotAttribute($name, $default = NULL) {
    return $this->original->session->getAttribute($name, $default);
  }

  /**
   * {@inheritdoc}
   */
  public function getChatbotSlot($name, $default = NULL) {
    return $this->original->getSlot($name, $default);
  }

}
