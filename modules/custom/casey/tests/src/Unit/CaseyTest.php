<?php

namespace Drupal\Tests\casey\Unit;

use Drupal\casey\Casey;
use Drupal\Tests\UnitTestCase;

class CaseyTest extends UnitTestCase {

  /**
   * @dataProvider providerTestToCamelCase
   */
  public function testToCamelCase($input, $expected, $message) {
    // Arrange.
    $casey = new Casey();
    // Act.
    $actual = $casey->toCamelCase($input);
    // Assert.
    $this->assertSame($expected, $actual, $message);
  }

  public function providerTestToCamelCase() {
    return [
      ['', '', 'Empty string.'],
      ['LoremIpsum', 'LoremIpsum', 'Already camel case.'],
      ['lorem', 'Lorem', 'Single word.'],
      ['lorem ipsum dolor sit amet', 'LoremIpsumDolorSitAmet', 'Multiple words.'],
      ['lorem  ipsum', 'LoremIpsum', 'Multiple spaces between words.'],
      ['lorem_ipsum', 'LoremIpsum', 'Underscore-separated words.'],
      ["lorem\t\n@!-ipsum", 'LoremIpsum', 'Unusual word separators.'],
    ];
  }

  /**
   * @expectedException \AssertionError
   * @expectedExceptionMessage Input must be a string.
   */
  public function testToCamelCaseInvalidInput() {
    // Arrange.
    $casey = new Casey();
    // Act.
    $casey->toCamelCase([]);
  }

  /**
   * @dataProvider providerTestToSnakeCase
   */
  public function testToSnakeCase($input, $expected, $message) {
    // Arrange.
    $casey = new Casey();
    // Act.
    $actual = $casey->toSnakeCase($input);
    // Assert.
    $this->assertSame($expected, $actual, $message);
  }

  public function providerTestToSnakeCase() {
    return [
      ['', '', 'Empty string.'],
      ['lorem_ipsum', 'lorem_ipsum', 'Already snake case.'],
      ['lorem', 'lorem', 'Single word.'],
      ['lorem ipsum dolor sit amet', 'lorem_ipsum_dolor_sit_amet', 'Multiple words.'],
      ['lorem  ipsum', 'lorem__ipsum', 'Multiple spaces between words.'],
      ['lorem_ipsum', 'lorem_ipsum', 'Underscore-separated words.'],
      ["lorem\t\n@!-ipsum", 'lorem_____ipsum', 'Unusual word separators.'],
    ];
  }

  /**
   * @expectedException \AssertionError
   * @expectedExceptionMessage Input must be a string.
   */
  public function testToSnakeCaseInvalidInput() {
    // Arrange.
    $casey = new Casey();
    // Act.
    $casey->toSnakeCase([]);
  }

}
