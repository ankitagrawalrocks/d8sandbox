<?php

namespace Drupal\contact_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Contact type entity.
 *
 * @ConfigEntityType(
 *   id = "contact_entity_type",
 *   label = @Translation("Contact type"),
 *   handlers = {
 *     "list_builder" = "Drupal\contact_entity\ContactEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\contact_entity\Form\ContactEntityTypeForm",
 *       "edit" = "Drupal\contact_entity\Form\ContactEntityTypeForm",
 *       "delete" = "Drupal\contact_entity\Form\ContactEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\contact_entity\ContactEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "contact_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "contact_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/contact_entity_type/{contact_entity_type}",
 *     "add-form" = "/admin/structure/contact_entity_type/add",
 *     "edit-form" = "/admin/structure/contact_entity_type/{contact_entity_type}/edit",
 *     "delete-form" = "/admin/structure/contact_entity_type/{contact_entity_type}/delete",
 *     "collection" = "/admin/structure/contact_entity_type"
 *   }
 * )
 */
class ContactEntityType extends ConfigEntityBundleBase implements ContactEntityTypeInterface {

  /**
   * The Contact type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Contact type label.
   *
   * @var string
   */
  protected $label;

}
