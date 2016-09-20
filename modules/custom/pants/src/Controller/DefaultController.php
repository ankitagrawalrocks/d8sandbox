<?php
namespace Drupal\pants\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends ControllerBase {

  /**
   * Current user
   *
   * @var AccountProxy
   */
  protected $currentUser;

  /** @var ImmutableConfig $defaultSettings  */
  protected $defaultSettings;

  /**
   * DefaultController constructor.
   *
   * @param \Drupal\Core\Session\AccountProxy $currentUser
   * @param \Drupal\Core\Config\ImmutableConfig $defaultSettings
   */
  public function __construct(AccountProxy $currentUser, ImmutableConfig $defaultSettings)
  {
    $this->currentUser = $currentUser;
    $this->defaultSettings = $defaultSettings;
  }

  public static function create(ContainerInterface $container) {
    $currentUser = $container->get('current_user');
    $defaultSettings = $container->get('config.factory')->get('pants.settings');
    return new static($currentUser, $defaultSettings);
  }

  public function colorAccess() {
    return AccessResult::allowedIf($this->currentUser->hasPermission('access pants color'));
  }

  public function color(AccountInterface $user) {
    $config = $this->defaultSettings;
    $pants_color = isset($user->pants_color->value) ? $user->pants_color->value : $config->get('default_color');
    return [
      '#markup' => $pants_color,
    ];
  }
}
