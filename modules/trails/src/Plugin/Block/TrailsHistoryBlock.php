<?php

namespace Drupal\trails\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
    $trail = \Drupal::state()->get('trails.history') ?: [];

    // Flip the saved array to show newest pages first.
    $reverse_trail = array_reverse($trail);

    // Grab the number of items to display
    $num_items = \Drupal::state()->get('trails.num_items') ?: 5;

    // Output the latest items as a list
    $output = ''; // Initialize variable, this was added after the video was created.
    for ($i = 0; $i < $num_items; $i++) {
      if ($item = $reverse_trail[$i]) {
        $output .= '<li>' . l($item['title'], $item['path']) . ' - ' . \Drupal::service('date')->formatInterval(REQUEST_TIME - $item['timestamp']) . ' ' . t('ago') . '</li>';
      }
    }
    if (isset($output)) {
      $output = '
            <p>' . t('Below are the last !num pages you have visited.', array('!num' => $num_items)) . '</p>
            <ul>' . $output . '</ul>
          ';
    }

    // Prepare to return the $block variable with subject (title) and content (output).
    $block['subject'] = 'History';
    $block['content'] = $output;

    return ['#markup' => $output];
  }

}
