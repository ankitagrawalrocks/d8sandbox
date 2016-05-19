<?php

/**
 * @file
 * Contains \Drupal\blindd8\Controller\Blindd8Controller.
 */

namespace Drupal\blindd8\Controller;

use Drupal\blindd8\BlindD8NotableEvent;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

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

    // Let's create a subrequest
    $request = \Drupal::service('request_stack');
    $subrequest = $request::create($request->getBaseUrl() . '/admin', 'GET', [], $request->cookies->all(), [], $request->server->all());
    $response = \Drupal::service('http_kernel')->handle($subrequest, HttpKernelInterface::SUB_REQUEST);

    $output = array(
//      '#markup' => $this->t('Hey @name, here is a unique ID for you: @uuid. @tagline @string', ['@name' => $name, '@uuid' => $uuid, '@tagline' => $tagline, '@string' => $string]),
      '#markup' => $response->getContent()
    );
    return $output;
  }
}
