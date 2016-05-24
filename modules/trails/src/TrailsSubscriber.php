<?php

/**
 * @file
 * Contains \Drupal\trails\TrailsSubscriber.
 */

namespace Drupal\trails;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Cmf\Component\Routing\RouteObjectInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Subscribes to the kernel request event to completely obliterate the default content.
 *
 * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
 *   The event to process.
 */
class TrailsSubscriber implements EventSubscriberInterface {


  /**
   * Redirects the user when they're requesting our nearly blank page.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The response event.
   */
  public function saveTrail(GetResponseEvent $event) {

    \Drupal::state()->delete('trails.trail');

    $request = \Drupal::request();
    if ($request->getMethod() != 'GET') {
      return;
    }

    // Grab the trail history from a variable
    //$trail = variable_get('trails_history', array());
    $trail = \Drupal::state()->get('trails.trail') ?: array();

    // Add current page to trail.
    $request = \Drupal::request();
    $route_match = \Drupal::routeMatch();
    $title = \Drupal::service('title_resolver')->getTitle($request, $route_match->getRouteObject());
    $current_path = \Drupal::request()->getRequestUri();

    $trail[] = array(
      'title' => strip_tags($title),
      'path' => $current_path,
      'timestamp' => REQUEST_TIME,
    );

    // Save the trail as a variable
    //variable_set('trails_history', $trail);
    \Drupal::state()->set('trails.trail', $trail);
  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents(){
    $events[KernelEvents::REQUEST][] = array('saveTrail');
    return $events;
  }

}