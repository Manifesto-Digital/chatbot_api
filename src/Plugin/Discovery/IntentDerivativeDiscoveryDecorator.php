<?php

namespace Drupal\chatbot_api\Plugin\Discovery;

use Drupal\Core\Plugin\Discovery\ContainerDerivativeDiscoveryDecorator;

class IntentDerivativeDiscoveryDecorator extends ContainerDerivativeDiscoveryDecorator {

  protected function encodePluginId($base_plugin_id, $derivative_id) {
    if ($derivative_id) {
      return $derivative_id;
    }

    return parent::encodePluginId($base_plugin_id, $derivative_id);
  }

}
