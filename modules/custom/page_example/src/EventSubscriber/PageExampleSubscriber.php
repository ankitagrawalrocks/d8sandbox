<?php

/**
 * @file
 * Contains \Drupal\page_example\PageExampleSubscriber.
 */

namespace Drupal\page_example\EventSubscriber;

use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\page_example\Event\SimplePageLoadEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribes to the kernel request event to completely obliterate the default content.
 *
 * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
 *   The event to process.
 */
class PageExampleSubscriber implements EventSubscriberInterface {

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  protected $logger;

  /**
   * PageExampleSubscriber constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactory $logger
   */
  public function __construct(LoggerChannelFactory $logger) {
    $this->logger = $logger->get('page_example_module');
  }

  /**
   * Logs message when simple page was viewed
   *
   * @param SimplePageLoadEvent $event
   *   The response event.
   */
  public function onPageLoad(SimplePageLoadEvent $event) {
    $event->setMessage('Simple page event subscriber was dispatched and subscribed.');
    $this->logger->notice('Simple page event subscriber was dispatched and subscribed.');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(){
    $events['page_example.simple_page_load'][] = array('onPageLoad');
    return $events;
  }

}