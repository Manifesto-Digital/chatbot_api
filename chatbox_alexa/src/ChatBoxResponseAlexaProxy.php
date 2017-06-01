<?php

namespace Drupal\chatbox_alexa;

use Alexa\Response\Response;
use Drupal\chatbox_api\ChatBoxResponseInterface;

/**
 * Proxy wrapping Alexa Response in a ChatBoxRequestInterface.
 *
 * @package Drupal\chatbox_alexa
 */
class ChatBoxResponseAlexaProxy implements ChatBoxResponseInterface {

  /**
   * Original object.
   *
   * @var \Alexa\Response\Response
   */
  protected $original;

  /**
   * ChatBoxResponseAlexaProxy constructor.
   *
   * @param \Alexa\Response\Response $original
   *   Original response instance.
   */
  public function __construct(Response $original) {
    $this->original = $original;
  }

  /**
   * Proxy-er calling original response methods.
   *
   * @param string $method
   *   The name of the method being called.
   * @param array $args
   *   Array of arguments passed to the method.
   *
   * @return mixed
   *   Value returned from the method.
   */
  public function __call($method, $args) {
    return call_user_func_array(array($this->original, $method), $args);
  }

  /**
   * {@inheritdoc}
   */
  public function addChatboxAttribute($name, $value) {
    $this->original->addSessionAttribute($name, $value);
  }

  /**
   * {@inheritdoc}
   */
  public function setChatboxRespond($text) {
    return $this->original->respond($text);
  }

  /**
   * {@inheritdoc}
   */
  public function setChatboxDisplayCard($title, $content = "") {
    return $this->original->withCard($title, $content);
  }

}
