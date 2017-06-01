<?php

namespace Drupal\chatbot_api;

/**
 * Request interface for Chatbot API.
 *
 * Request wrapper for services who want to work with Chatbot API.
 */
interface ChatbotRequestInterface {

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
  public function getChatbotAttribute($name, $default = NULL);

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
  public function getChatbotSlot($name, $default = NULL);

}
