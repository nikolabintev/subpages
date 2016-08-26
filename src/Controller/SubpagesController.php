<?php

namespace Drupal\subpages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
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

    foreach ($subpages as $subpage) {
      $row = [];
      $row['data']['subpage'] = $subpage['title'];
      $row['data']['view_mode'] = $subpage['view_mode'];


      $operations = array();
      /*
      $operations['edit'] = array(
        'title' => $this->t('Edit'),
        'url' => Url::fromRoute('path.admin_edit', ['pid' => $data->pid], ['query' => $destination]),
      );
      */
      $operations['delete'] = [
        'title' => $this->t('Delete'),
        'url' => \Drupal\Core\Url::fromRoute('subpages.delete', ['node_type' => $node_type, 'subpage' => 'home']),
      ];

      $row['data']['operations'] = array(
        'data' => array(
          '#type' => 'operations',
          '#links' => $operations,
        ),
      );

      $rows[] = $row;
    }
    $build['subpages'] = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No sub-pages available for this node type'),
    );

    return $build;
  }

  /**
   * Deletes sub-page
   * @param $node_type
   *  The node type on which the sub-page appears.
   * @param $subpage
   *  The sub-page to delete.
   */
  public function delete($node_type, $subpage) {
    echo 5;
  }
}
