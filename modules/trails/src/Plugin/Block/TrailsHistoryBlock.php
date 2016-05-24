<?php

namespace Drupal\trails\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Provides a 'Powered by Drupal' block.
 *
 * @Block(
 *   id = "trails_history_block",
 *   admin_label = @Translation("Trails history")
 * )
 */
class TrailsHistoryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Create list of previous paths.

    // Grab the trail history from a variable
    $trail = \Drupal::state()->get('trails.trail') ?: [];

    // Flip the saved array to show newest pages first.
    $reverse_trail = array_reverse($trail);

    // Grab the number of items to display
    $num_items = $this->configuration['num_to_show'] ?: 5;

    // Output the latest items as a list
    $output = ''; // Initialize variable, this was added after the video was created.
    $items = [];

    for ($i = 0; $i < $num_items; $i++) {
      if ($item = $reverse_trail[$i]) {
        $link = Link::fromTextAndUrl($item['title'], Url::fromUserInput($item['path']));
        $html = $link->toString()->getGeneratedLink();
        $items[] = [ 'link' => $html, 'ago' => \Drupal::service('date.formatter')->formatInterval(REQUEST_TIME - $item['timestamp']) ];
      }
    }
    if (isset($output)) {
      $output = '
            <p>' . t('Below are the last @num pages you have visited.', array('@num' => $num_items)) . '</p>
            <ul>' . $output . '</ul>
          ';
    }

    // Prepare to return the $block variable with subject (title) and content (output).
    $block['subject'] = 'History';
    $block['content'] = $output;

    return ['#theme' => 'trails_list', '#num_items' => $num_items, '#items' => $items];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    // Get the maximum allowed value from the configuration form.
    $max_to_display = \Drupal::config('trails.settings')->get('max_in_settings');

    // Add a select box of numbers form 1 to $max_to_display.
    $form['trails_block_num'] = array(
      '#type' => 'select',
      '#title' => t('Number of items to show'),
      '#default_value' => $this->configuration['num_to_show'] ?: 5,
      '#options' => array_combine(range(1, $max_to_display), range(1, $max_to_display)),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['num_to_show'] = $form_state->getValue('trails_block_num');
  }
}
