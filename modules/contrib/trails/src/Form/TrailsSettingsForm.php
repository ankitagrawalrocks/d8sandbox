<?php

namespace Drupal\trails\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configures image toolkit settings for this site.
 */
class TrailsSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'trails_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['trails.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Add a select box of numbers form 1 to $max_to_display.
    $form['max_in_settings'] = array(
      '#type' => 'select',
      '#title' => $this->t('Number of items to show'),
      '#options' => array_combine(range(1, 200), range(1, 200)),
      '#default_value' => $this->config('trails.settings')->get('max_in_settings'),
      '#description' => $this->t('This will set the maximum allowable number that can be displayed in a history block.'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('trails.settings')
      ->set('max_in_settings', $form_state->getValue('max_in_settings'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
