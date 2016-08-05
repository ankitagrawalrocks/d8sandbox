<?php

namespace Drupal\composer_example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configures image toolkit settings for this site.
 */
class LatLongForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'latlong_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['composer_example.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['default_latitude'] = array(
      '#type' => 'number',
      '#title' => $this->t('Default Latitude'),
      '#default_value' => $this->config('composer_example.settings')->get('default_latitude'),
      '#required' => TRUE,
      '#step' => 0.000001
    );

    $form['default_longitude'] = array(
      '#type' => 'number',
      '#title' => $this->t('Default Longitude'),
      '#default_value' => $this->config('composer_example.settings')->get('default_longitude'),
      '#required' => TRUE,
      '#step' => 0.000001
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('composer_example.settings')
      ->set('default_latitude', $form_state->getValue('default_latitude'))
      ->set('default_longitude', $form_state->getValue('default_longitude'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
