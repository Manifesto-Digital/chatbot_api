<?php

namespace Drupal\chatbot_api\Plugin\Discovery;

use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;

class IntentDerivativeDiscoveryDecorator extends ContainerDerivativeDiscoveryDecorator {

  /**
   * {@inheritdoc}
   */
  protected function encodePluginId($base_plugin_id, $derivative_id) {

    // Use derivative_id (intent name) as plugin ID.
    if ($derivative_id) {
      return $derivative_id;
    }

    return parent::encodePluginId($base_plugin_id, $derivative_id);
  }

}
