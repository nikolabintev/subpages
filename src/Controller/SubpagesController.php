<?php

namespace Drupal\subpages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\subpages\SubpagesManager;

/**
 * Class SubpagesController.
 *
 * @package Drupal\subpages\Controller
 */
class SubpagesController extends ControllerBase
{

  /**
   * Drupal\subpages\SubpagesManager definition.
   *
   * @var \Drupal\subpages\SubpagesManager
   */
  protected $subpagesManager;

  /**
   * {@inheritdoc}
   */
  public function __construct(SubpagesManager $subpages_manager)
  {
    $this->subpagesManager = $subpages_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('subpages.manager')
    );
  }

  /**
   * Subpages.
   *
   * @return string
   *   Return Hello string.
   */
  public function subpages($node_type) {
    $build = [];

    $header = [];
    $header[] = [
      'data' => $this->t('Subpage'),
      'field' => 'subpage',
    ];
    $header[] = [
      'data' => $this->t('View mode'),
      'field' => 'view_mode',
    ];
    $header[] = $this->t('Operations');

    $rows = [];

    $subpages = $this->subpagesManager->getSubpages($node_type);

    foreach ($subpages as $key => $subpage) {
      $row = [];
      $row['data']['subpage'] = $subpage['title'];
      $row['data']['view_mode'] = $subpage['view_mode'];

      $rows[] = $row;
    }
    $build['subpages'] = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No sub-pages available for this node type'),
//      '#empty' => $this->t('No URL aliases available. <a href=":link">Add URL alias</a>.', array(':link' => $this->url('path.admin_add'))),
    );

    return $build;
  }
}
