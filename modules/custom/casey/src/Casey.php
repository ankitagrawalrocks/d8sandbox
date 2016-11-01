<?php

namespace Drupal\casey;

class Casey {

  public function toCamelCase($string) {
    if (!is_string($string)) {
      throw new \AssertionError('Input must be a string.');
    }
    $string = preg_replace('/[^[:alnum:]]/', ' ', $string);
    $string = ucwords($string);
    $string = str_replace(' ', '', $string);
    return $string;
  }

  public function toSnakeCase($string) {
    if (!is_string($string)) {
      throw new \AssertionError('Input must be a string.');
    }
    $string = preg_replace('/[^[:alnum:]]/', '_', $string);
    $string = str_replace(' ', '_', $string);
    $string = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $string)), '_');
    return $string;
  }
}
