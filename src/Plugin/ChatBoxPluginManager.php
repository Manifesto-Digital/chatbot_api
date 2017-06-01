<?php

namespace Drupal\chatbox_api\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Chatbox Plugin plugin manager.
 */
class ChatBoxPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new ChatBoxPluginManager object.
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
    parent::__construct('Plugin/ChatBox', $namespaces, $module_handler, 'Drupal\chatbox_api\Plugin\ChatBoxPluginInterface', 'Drupal\chatbox_api\Annotation\ChatBox');

    $this->alterInfo('chatbox_info');
    $this->setCacheBackend($cache_backend, 'chatbox_info_plugins');

    $this->factory;
  }

  /**
   * {@inheritdoc}
   */
  public function createInstance($plugin_id, array $configuration = array()) {
    $instance = parent::createInstance($plugin_id, $configuration);
    if ($instance instanceof ChatBoxPluginBase) {
      $instance->set($this->moduleHandler);
      $instance->setViewsData($this->viewsData);
    }
    return $instance;
  }

}
