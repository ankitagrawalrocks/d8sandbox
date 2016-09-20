<?php
namespace Drupal\pants\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class PantsSettings extends ConfigFormBase {
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('pants.settings');
    $available_colors = $config->get('available_colors');
    $options = array_combine($available_colors, $available_colors);
    $form['default_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Default color'),
      '#options' => $options,
      '#default_value' => $config->get('default_color')
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('pants.settings');
    $config->set('default_color', $form_state->getValue('default_color'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

    if ($form_state->getValue('default_color') == 'green') {
      $form_state->setErrorByName('default_color', $this->t('This value is not allowed'));
    }

    parent::validateForm($form, $form_state);
  }

  public function getFormId() {
    return 'pants.settings';
  }

  public function getEditableConfigNames() {
    return ['pants.settings'];
  }

}