<?php

namespace Drupal\config_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configures image toolkit settings for this site.
 */
class ConfigFormSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    // Add a select box of numbers form 1 to $max_to_display.
    $form['some_text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Some text'),
      '#default_value' => $this->config('config_form.settings')->get('some_text'),
      '#required' => TRUE,
    );

    // Add a select box of numbers form 1 to $max_to_display.
    $form['some_select'] = array(
      '#type' => 'select',
      '#title' => $this->t('Some select'),
      '#options' => array_combine(range(1, 200), range(1, 200)),
      '#default_value' => $this->config('config_form.settings')->get('some_select'),
      '#required' => TRUE,
    );

    // Add a radio button
    $form['some_radio'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Some radio'),
      '#options' => array('one', 'two', 'three'),
      '#default_value' => $this->config('config_form.settings')->get('some_radio'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('config_form.settings')
      ->set('some_text', $form_state->getValue('some_text'))
      ->set('some_select', $form_state->getValue('some_select'))
      ->set('some_radio', $form_state->getValue('some_radio'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
