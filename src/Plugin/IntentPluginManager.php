<?php

namespace Drupal\chatbot_api\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Intent Plugin plugin manager.
 */
class IntentPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new IntentPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/Chatbot/Intent', $namespaces, $module_handler, 'Drupal\chatbot_api\Plugin\IntentPluginInterface', 'Drupal\chatbot_api\Annotation\Intent');

    $this->alterInfo('chatbot_intent_info');
    $this->setCacheBackend($cache_backend, 'chabot_intent_plugins');
  }

}
