<?php

namespace Drupal\chatbox_api\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a ChatBox Plugin item annotation object.
 *
 * @see \Drupal\chatbox_api\Plugin\ChatboxPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class ChatBox extends Plugin {


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
