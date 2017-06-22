<?php

namespace Drupal\chatbot_api_apiai;

use ApiAi\Model\Context;
use Drupal\api_ai_webhook\ApiAi\Model\Webhook\Request;
use Drupal\chatbot_api\IntentRequestInterface;

/**
 * Proxy wrapping Api.ai Request in a IntentRequestInterface.
 *
 * @package Drupal\chatbot_api_apiai
 */
class IntentRequestApiAiProxy implements IntentRequestInterface {

  use ApiAiContextTrait;

  /**
   * Original object.
   *
   * @var \ApiAi\Model\Webhook\Request
   */
  protected $original;

  /**
   * IntentRequestAlexaProxy constructor.
   *
   * @param \ApiAi\Model\Webhook\Request $original
   *   Original request instance.
   */
  public function __construct(Request $original) {
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
  public function getIntentName() {
    return $this->original->getResult()->getMetadata()->getIntentName();
  }

  /**
   * {@inheritdoc}
   */
  public function getIntentAttribute($name, $default = NULL) {
    $value = $default;
    $contexts = $this->original->getResult()->getContexts();

    // Extract context.
    if (isset($contexts[$this->getContextName($name)]) && $contexts[$this->getContextName($name)] instanceof Context) {

      // API.ai supports context parameters. Intents can get/set parameters
      // by separating the context name and the parameter name with a period
      // i.e. context_name.parameter_name .
      $params = $contexts[$this->getContextName($name)]->getParameters();

      $value = isset($params[$this->getParameterName($name)]) ? $params[$this->getParameterName($name)] : $default;
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  public function getIntentSlot($name, $default = NULL) {
    $params = $this->original->getResult()->getParameters();

    return isset($params[$name]) ? $params[$name] : $default;
  }

}
