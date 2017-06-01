<?php

namespace Drupal\chatbox_alexa;

use Alexa\Request\IntentRequest;
use Drupal\chatbox_api\ChatBoxRequestInterface;

/**
 * Proxy wrapping Alexa Request in a ChatBoxRequestInterface.
 *
 * @package Drupal\chatbox_alexa
 */
class ChatBoxRequestAlexaProxy implements ChatBoxRequestInterface {

  /**
   * Original object.
   *
   * @var \Alexa\Request\IntentRequest
   */
  protected $original;

  /**
   * ChatBoxRequestAlexaProxy constructor.
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
  public function getChatboxAttribute($name, $default = NULL) {
    $this->original->session->getAttribute($name, $default);
  }

  /**
   * {@inheritdoc}
   */
  public function getChatboxSlot($name, $default = NULL) {
    $this->original->getSlot($name, $default);
  }

}
