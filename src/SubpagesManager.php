<?php

namespace Drupal\subpages;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\subpages\SubpagesManagerInterface;
use Drupal\Core\Entity\EntityManagerInterface;
/**
 * Class SubpagesManager.
 *
 * @package Drupal\subpages
 */
class SubpagesManager implements SubpagesManagerInterface {

  /**
   * @var \Drupal\Core\Config\Config
   */
  private $configFactory;
  private $config;
  private $entityManager;

  /**
   * Constructor.
   */
  public function __construct(EntityManagerInterface $entityManager, ConfigFactoryInterface $configFactory) {
    $this->entityManager = $entityManager;
    $this->configFactory = $configFactory;

    $this->config = $configFactory
      ->getEditable('subpages.settings');

  }

  /**
   * {@inheritdoc}
   */
  public function getViewModes($node_type) {
    $view_modes = [];

    $results = \Drupal::entityQuery('entity_view_display')
//      ->condition('id', ['node']/*NestedArray::mergeDeepArray($candidate_ids)*/)
      ->condition('status', TRUE)
      ->execute();


    foreach ($results as $result) {
      $res = explode('.', $result);

      if ($res[0] == 'node' && $res[1] == $node_type) {
        $view_modes[$res[2]] = $res[2];
      }
    }

    return $view_modes;
  }

  public function getSubpages($node_type) {
    return $this->config->get($node_type);
  }

  public function addSubpage($node_type, $subpage) {
    $this->config
      ->set($node_type . '.' . strtolower(str_replace(' ', '_', $subpage['title'])). '.title', $subpage['title'])
      ->set($node_type . '.' . strtolower(str_replace(' ', '_', $subpage['title'])). '.view_mode', $subpage['view_mode'])
      ->save();
  }

  public function deleteSubpage($node_type, $subpage) {
    
  }
}
