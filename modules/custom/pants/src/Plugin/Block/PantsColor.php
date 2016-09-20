<?php

namespace Drupal\pants\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class PantsColor, also serves as an example of DI
 * IMPORTANT: To be able to use DI, it MUST implement ContainerFactoryPluginInterface
 *
 * @Block(
 *   id = "pants_color",
 *   admin_label = @Translation("Default pants color")
 * )
 * @package Drupal\pants\Plugin\Block
 */
class PantsColor extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Default settings of pants module
   *
   * @var ImmutableConfig $defaultSettings
   */
  protected $defaultSettings;

  /**
   * Constructs a new PantsColorBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param ImmutableConfig $defaultSettings
   *   Configuration for module.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ImmutableConfig $defaultSettings) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->defaultSettings = $defaultSettings;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory')->get('pants.settings')
    );
  }

  public function build() {
    return [
      '#markup' => $this->t('The default color is @color', ['@color' => $this->defaultSettings->get('default_color')]),
    ];
  }
}