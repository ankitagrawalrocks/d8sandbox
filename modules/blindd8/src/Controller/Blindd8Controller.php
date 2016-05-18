<?php

/**
 * @file
 * Contains \Drupal\blindd8\Controller\Blindd8Controller.
 */

namespace Drupal\blindd8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines a controller to experiment with.
 */
class Blindd8Controller extends ControllerBase
{

  /**
   * Provides a page that we can experiment with.
   *
   * @return array
   *   A render array as expected by drupal_render().
   */
  public function content()
  {
    $account = \Drupal::currentUser();
    $name = $account->getDisplayName();

    $uuid_generator = \Drupal::service('uuid');
    $uuid = $uuid_generator->generate();

    $output = array(
      '#markup' => $this->t('Hey @name, here is a unique ID for you: @uuid.', ['@name' => $name, '@uuid' => $uuid]),
    );
    return $output;
  }
}
