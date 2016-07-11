<?php

/**
 * @file
 * Contains \Drupal\blindd8\BlindD8ingService.
 */

namespace Drupal\blindd8;

class BlindD8ingService implements BlindD8ingServiceInterface {
  public function getTagline() {
    return t('D8ting is fun with Drupal!');
  }
}