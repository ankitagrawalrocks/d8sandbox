<?php

/**
 * @file
 * Contains \Drupal\my_assets\Controller\MyAssetsController.
 */

namespace Drupal\my_assets\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class MyAssetsController.
 */
class MyAssetsController extends ControllerBase
{
  /**
   * Index page for attach assets example.
   *
   * @return mixed
   *   Render array.
   */
  public function index() {
    $header = [
      $this->t('Title'),
      $this->t('Operations')
    ];

    $rows = [
      [
        'row1',
        'row2'
      ],
      [
        'row3',
        'row4'
      ]
    ];

    $build['content'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No content created yet.'),
    ];

    return $build;
  }

}
