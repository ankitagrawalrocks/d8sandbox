<?php

namespace Drupal\page_example\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Creates event when simple page is being loaded.
 */
class SimplePageLoadEvent extends Event {

  protected $message;

  public function __construct($message) {
    $this->message = $message;
  }
  /**
   * @return mixed
   */
  public function getMessage() {
    return $this->message;
  }
  /**
   * @param mixed $message
   */
  public function setMessage($message) {
    $this->message = $message;
  }

}
