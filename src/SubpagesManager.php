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
  private $entityManager;

  /**
   * Constructor.
   */
  public function __construct(EntityManagerInterface $entityManager, ConfigFactoryInterface $configFactory) {
    $this->entityManager = $entityManager;
    $this->configFactory = $configFactory;
    /*
    $this->config_factory = $config_factory
      ->getEditable('exclude_view_title.settings');
    */
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

    $a = 5;
    return $view_modes;

      /*
    $definitions = [];

    foreach ($this->entityManager->getDefinitions() as $entity_type => $definition) {
      if ($definition->isSubclassOf('Drupal\Core\Config\Entity\ConfigEntityInterface')) {
        if ($definition->getBundleOf()) {
          $definitions[$entity_type] = $definition;
        }
      }
    }
    $entity_types = array_map(function (EntityTypeInterface $definition) {
      return $definition->getLabel();
    }, $definitions);
    // Sort the entity types by label, then add the simple config to the top.
    uasort($entity_types, 'strnatcasecmp');

    return $entity_types;
      */
  }

  public function getSubpages($node_type) {
    $config = $this->configFactory->getEditable('subpages.AddSubpage');
    $subpages = [];

    $subpages = $config->get($node_type);

    $a =5;
    return $subpages;
  }
}
