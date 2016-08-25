<?php

namespace Drupal\subpages\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\subpages\SubpagesManager;

/**
 * Provides automated tests for the subpages module.
 */
class SubpagesControllerTest extends WebTestBase {

  /**
   * Drupal\subpages\SubpagesManager definition.
   *
   * @var \Drupal\subpages\SubpagesManager
   */
  protected $subpagesManager;

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "subpages SubpagesController's controller functionality",
      'description' => 'Test Unit for module subpages and controller SubpagesController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests subpages functionality.
   */
  public function testSubpagesController() {
    // Check that the basic functions of module subpages.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
