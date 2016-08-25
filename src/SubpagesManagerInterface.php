<?php

namespace Drupal\subpages;

/**
 * Interface SubpagesManagerInterface.
 *
 * @package Drupal\subpages
 */
interface SubpagesManagerInterface {

  /**
   * Get all configurations
   * @return mixed
   */
  public function getViewModes($node_type);
}
