<?php

namespace Drupal\chatbot_api;

/**
 * Request interface for Chatbot API.
 *
 * Request wrapper for services who want to work with Chatbot API.
 */
interface ChatbotResponseInterface {

  /**
   * Set or Add session attribute.
   *
   * @param string $name
   *   The attribute name to be added.
   * @param mixed $value
   *   The attribute value.
   *
   * @return self
   *   The current ChatbotResponseInterface instance.
   */
  public function addChatbotAttribute($name, $value);

  /**
   * Set output speech as text.
   *
   * @param string $text
   *   The output message.
   *
   * @return self
   *   The current ChatbotResponseInterface instance.
   */
  public function setChatbotRespond($text);

  /**
   * Add text to be displayed on the user device screen.
   *
   * Display this text together with the speach response i.e. as card (Alexa)
   * or on the Device screen (API.ai).
   *
   * @param string $content
   *   The content to be displayed.
   * @param string $title
   *   The title of current card. This is not implemented by all APIs.
   *
   * @return self
   *   The current ChatbotResponseInterface instance.
   */
  public function setChatbotDisplayCard($content, $title = NULL);

}
