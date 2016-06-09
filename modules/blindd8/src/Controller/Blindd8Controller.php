<?php

/**
 * @file
 * Contains \Drupal\blindd8\Controller\Blindd8Controller.
 */

namespace Drupal\blindd8\Controller;

use Drupal\blindd8\BlindD8NotableEvent;
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
    // Custom event dispatch
    $string = 'This is the default string';
    $event = new BlindD8NotableEvent($string);
    \Drupal::service('event_dispatcher')->dispatch('blindd8.notable_event', $event);
    $string = $event->getString();

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

    // Display configuration
    $some_text = \Drupal::config('blindd8.settings')->get('some_text');
    $some_select = \Drupal::config('blindd8.settings')->get('some_select');
    $some_radio = \Drupal::config('blindd8.settings')->get('some_text');

    $output = array(
      '#markup' => $this->t('Hey @name, here is a unique ID for you: @uuid. @tagline @string', ['@name' => $name, '@uuid' => $uuid, '@tagline' => $tagline, '@string' => $string]),
    );
    return $output;
  }
}
