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
    // User name
    $account = \Drupal::currentUser();
    $name = $account->getDisplayName();

    // Generate UUID
    /** @var \Drupal\Component\Uuid\Php $uuid_generator */
    $uuid_generator = \Drupal::service('uuid');
    $uuid = $uuid_generator->generate();

    // Call a service
    /** @var \Drupal\blindd8\BlindD8ingService $blindd8ingservice */
    $blindd8ingservice = \Drupal::service('blindd8.blindd8ingservice');
    $tagline = $blindd8ingservice->getTagline();

    $output = array(
      '#markup' => $this->t('Hey @name, here is a unique ID for you: @uuid. @tagline', ['@name' => $name, '@uuid' => $uuid, '@tagline' => $tagline]),
    );
    return $output;
  }
}
