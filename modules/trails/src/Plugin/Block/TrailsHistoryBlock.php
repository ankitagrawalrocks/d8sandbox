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
    return array('#markup' => $this->t('Hello world!'));
  }

}
