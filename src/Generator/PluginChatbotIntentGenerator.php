<?php

/**
 * @file
 * Contains \Drupal\Console\Generator\PluginFieldTypeGenerator.
 */

namespace Drupal\chatbot_api\Generator;

use Drupal\Console\Core\Generator\Generator;
use Drupal\Console\Extension\Manager;

class PluginChatbotIntentGenerator extends Generator {
    /**
     * PluginChatbotIntentGenerator constructor.
     *
     * @param Manager $extensionManager
     */
    public function __construct(Manager $extensionManager) {
        $this->extensionManager = $extensionManager;
    }

    /**
     * Generator Plugin Chatbot Intent.
     *
     * @param string $module            Module name
     * @param string $class_name        Plugin Class name
     * @param string $label             Plugin label
     * @param string $plugin_id         Plugin id
     */
    public function generate($module, $class_name, $label, $plugin_id) {
        $parameters = [
            'module' => $module,
            'class_name' => $class_name,
            'label' => $label,
            'plugin_id' => $plugin_id,
        ];

        $this->renderer->addSkeletonDir(__DIR__ . '/../../console/templates');

        $this->renderFile(
            'module/src/Plugin/Chatbot/Intent/intent.php.twig',
            $this->extensionManager->getPluginPath($module, 'Chatbot/Intent') . '/' . $class_name . '.php',
            $parameters
        );
    }
}
