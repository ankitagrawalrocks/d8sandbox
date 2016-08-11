<?php

namespace Drupal\composer_example\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Forecast\Forecast;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Lat-Long' block with dependency injection.
 * IMPORTANT: To be able to use DI, it MUST implement ContainerFactoryPluginInterface
 *
 * @Block(
 *   id = "lat_long_block",
 *   admin_label = @Translation("Latitude and Longitude Weather forecast")
 * )
 */
class LatLongBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /** @var ImmutableConfig $defaultSettings  */
  protected $defaultSettings;

  /**
   * Constructs a new BookNavigationBlock instance.
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
      $container->get('config.factory')->get('composer_example.settings')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $latitude = $this->configuration['latitude'] ?: $this->defaultSettings->get('default_latitude');
    $longitude = $this->configuration['longitude'] ?: $this->defaultSettings->get('default_longitude');

    $forecast = new Forecast('7411b0e6d5e0c99fbd7405fd6de00cd5');
    $forecastResult = $forecast->get($latitude, $longitude);

    return ['#markup' => 'latitude: '.$latitude.', longitude: '.$longitude. ' Forecast: '.$forecastResult->hourly->summary];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    if (!isset($this->configuration['latitude'])) {
      $this->configuration['latitude'] = $this->defaultSettings->get('default_latitude');
    }

    if (!isset($this->configuration['longitude'])) {
      $this->configuration['longitude'] = $this->defaultSettings->get('default_longitude');
    }

    $form['latitude'] = array(
      '#type' => 'number',
      '#title' => $this->t('Latitude'),
      '#default_value' => $this->configuration['latitude'],
      '#required' => TRUE,
      '#step' => 0.000001
    );

    $form['longitude'] = array(
      '#type' => 'number',
      '#title' => $this->t('Longitude'),
      '#default_value' => $this->configuration['longitude'],
      '#required' => TRUE,
      '#step' => 0.000001
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['latitude'] = $form_state->getValue('latitude');
    $this->configuration['longitude'] = $form_state->getValue('longitude');
  }
}
