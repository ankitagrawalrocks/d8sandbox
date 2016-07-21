<?php

namespace Drupal\my_assets\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Powered by Drupal' block.
 *
 * @Block(
 *   id = "my_assets_some_static_block",
 *   admin_label = @Translation("Static Block as example for assets demo")
 * )
 */
class SomeStaticBlock extends BlockBase {

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
    return [
      '#markup' => '<span>' . $this->t('I am some static block!') . '</span>',
      '#attached' => [
        'library' => [
          'my_assets/hackers-lib'
        ],
        'drupalSettings' => [
          'my_assets' => [
            'hackersLib' => [
              'bgColor' => '#FF0000'
            ]
          ]
        ]
      ],
    ];
  }

}
