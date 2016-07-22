<?php

namespace Drupal\contact_entity\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Contact entities.
 */
class ContactEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['contact_entity']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Contact'),
      'help' => $this->t('The Contact ID.'),
    );

    return $data;
  }

}
