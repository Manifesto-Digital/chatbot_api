<?php

namespace Drupal\chatbox_api;

/**
 * Request interface for Chatbox API.
 *
 * Request wrapper for services who want to work with Chatbox API.
 */
interface ChatBoxRequestInterface {

  /**
   * Get session attribute.
   *
   * @param string $name
   *   The attribute name to be returned.
   * @param mixed $default
   *   A default value if the attribute is not found.
   *
   * @return mixed
   *   The attribute value.
   */
  public function getChatboxAttribute($name, $default = NULL);

  /**
   * Get session slot.
   *
   * @param string $name
   *   The slot name to be returned.
   * @param mixed $default
   *   A default value if the slot is not found.
   *
   * @return string
   *   The slot value.
   */
  public function getChatboxSlot($name, $default = NULL);

}
