<?php
/**
 * @file
 * Contains Drupal\cron_queuing\Plugin\Filter\FilterCapitalize.php
 */

namespace Drupal\capitalize\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Class FilterCapitalize
 *
 * @Filter(
 *   id = "filter_capitalize",
 *   title = @Translation("Capitalize Filter"),
 *   description = @Translation("Capitelizes first letters of selected words!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_IRREVERSIBLE,
 * )
 * @package Drupal\capitalize\Plugin\Filter
 */
class FilterCapitalize extends FilterBase {

  /**
   * Performs the filter processing.
   *
   * @param string $text
   *   The text string to be filtered.
   * @param string $langcode
   *   The language code of the text to be filtered.
   *
   * @return \Drupal\filter\FilterProcessResult
   *   The filtered text, wrapped in a FilterProcessResult object, and possibly
   *   with associated assets, cacheability metadata and placeholders.
   *
   * @see \Drupal\filter\FilterProcessResult
   */
  public function process($text, $langcode) {
    $wordsParts = explode(',', $this->settings['words']);
    foreach ($wordsParts as $part) {
      $part = ucfirst(trim($part));
      $text = preg_replace('/'.$part.'/i', $part, $text);
    }

    // see https://www.lullabot.com/articles/creating-a-custom-filter-in-drupal-8 how to attach css to the result
    return new FilterProcessResult($text);
  }

  public function settingsForm(array $form, FormStateInterface $form_state) {
    if (!isset($this->settings['words'])) {
      $this->settings['words'] = '';
    }

    $form['words'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Words to capitalize'),
      '#default_value' => $this->settings['words'],
      '#description' => $this->t('Enter a list of words in small case which should be capitalized. <br/>Separate multiple words with comma (,)<br/><br/>Example: drupal, wordpress,joomla'),
    );
    return $form;
  }
}