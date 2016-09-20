<?php
/**
 * @file
 * Contains \Drupal\pants\Plugin\Block\ChangePants.
 */
namespace Drupal\pants\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\user\Entity\User;
use Drupal\user\UserStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the PantsUserColor block.
 *
 * @Block(
 *   id = "pants_user_color",
 *   admin_label = @Translation("Specific user's pants color")
 * )
 */
class PantsUserColor extends BlockBase  implements ContainerFactoryPluginInterface {

  /**
   * The user storage.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $userStorage;

  /**
   * Default settings of pants module
   *
   * @var ImmutableConfig $defaultSettings
   */
  protected $defaultSettings;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, UserStorageInterface $user_storage, ImmutableConfig $defaultSettings) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->userStorage = $user_storage;
    $this->defaultSettings = $defaultSettings;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager')->getStorage('user'),
      $container->get('config.factory')->get('pants.settings')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array(
      'user' => 1,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $users = $this->userStorage->loadMultiple();
    $options = array();

    /** @var User $user */
    foreach ($users as $user) {
      if ($user->id() != 0) {
        $options[$user->id()] = $user->getDisplayName();
      }
    }

    $form['user'] = array(
      '#type' => 'select',
      '#options' => $options,
      '#default_value' => $this->configuration['user'],
      '#title' => $this->t('Select the user to display his pants color'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['user'] = $form_state->getValue('user');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    /** @var User $user */
    $user = $this->userStorage->load($this->configuration['user']);
    $config = $this->defaultSettings;
    $pants_color = isset($user->get('field_pants_color')->value) ? $user->get('field_pants_color')->value : $config->get('default_color');
    $url = Url::fromRoute('pants.color', ['user' => $user->id()]);
    $link = Link::fromTextAndUrl($this->t('See details'), $url);
    return [
      'color' => [
        '#markup' => $user->getDisplayName() . ' ' . $this->t(' pants are') . ' ' . $pants_color,
      ],
      'link' => [
        '#prefix' => '<br/>',
        '#markup' => $link->toString(),
      ],
    ];
  }
}