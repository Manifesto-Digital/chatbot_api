<?php

namespace Drupal\chatbot_alexa\EventSubscriber;

use Drupal\alexa\AlexaEvent;
use Drupal\chatbot_alexa\ChatbotRequestAlexaProxy;
use Drupal\chatbot_alexa\ChatbotResponseAlexaProxy;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * An event subscriber for Alexa request events.
 */
class RequestSubscriber implements EventSubscriberInterface {

  /**
   * Gets the event.
   */
  public static function getSubscribedEvents() {
    $events['alexaevent.request'][] = array('onRequest', 0);
    return $events;
  }

  /**
   * Called upon a request event.
   *
   * @param \Drupal\alexa\AlexaEvent $event
   *   The event object.
   */
  public function onRequest(AlexaEvent $event) {
    /** @var \Drupal\chatbot_alexa\ChatbotRequestAlexaProxy|\Alexa\Request\IntentRequest $request */
    $request = new ChatbotRequestAlexaProxy($event->getRequest());
    $response = new ChatbotResponseAlexaProxy($event->getResponse());

    /** @var \Drupal\chatbot_api\Plugin\ChatbotPluginManager $manager */
    $manager = \Drupal::service('plugin.manager.chatbot_plugin');
    if ($manager->hasDefinition($request->intentName)) {

      $configuration = [
        'request' => $request,
        'response' => $response,
      ];
      $plugin = $manager->createInstance($request->intentName, $configuration);
      $plugin->process();
    }
  }

}
