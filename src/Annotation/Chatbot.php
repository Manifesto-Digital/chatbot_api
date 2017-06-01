<?php

namespace Drupal\chatbot_api\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Chatbot Plugin item annotation object.
 *
 * @see \Drupal\chatbot_api\Plugin\ChatbotPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class Chatbot extends Plugin {


  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
