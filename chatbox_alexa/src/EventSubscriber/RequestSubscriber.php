<?php

namespace Drupal\chatbot_alexa\EventSubscriber;

use Drupal\alexa\AlexaEvent;
use Drupal\chatbox_alexa\ChatBoxRequestAlexaProxy;
use Drupal\chatbox_alexa\ChatBoxResponseAlexaProxy;
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
    /** @var \Drupal\chatbox_alexa\ChatBoxRequestAlexaProxy|\Alexa\Request\IntentRequest $request */
    $request = new ChatBoxRequestAlexaProxy($event->getRequest());
    $response = new ChatBoxResponseAlexaProxy($event->getResponse());

    /** @var \Drupal\chatbox_api\Plugin\ChatBoxPluginManager $manager */
    $manager = \Drupal::service('plugin.manager.chatbox_plugin');
    if ($manager->hasDefinition($request->intentName)) {
      $plugin = $manager->createInstance($request->intentName);
      $plugin->request = $request;
      $plugin->response = $response;
      $plugin->process();
    }
  }

}
