<?php

namespace Drupal\subpages\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\subpages\SubpagesManager;

/**
 * Class DeleteSubpageForm.
 *
 * @package Drupal\subpages\Form
 */
class DeleteSubpageForm extends FormBase {

  /**
   * Drupal\subpages\SubpagesManager definition.
   *
   * @var \Drupal\subpages\SubpagesManager
   */
  protected $subpagesManager;

  public function __construct(SubpagesManager $subpages_manager) {
    $this->subpagesManager = $subpages_manager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('subpages.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_subpage_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_type = NULL, $subpage = NULL) {
    echo $node_type;
    echo $subpage;

    $form['node_type'] = [
      '#type' => 'hidden',
      '#value' => $node_type,
    ];

    $form['subpage'] = [
      '#type' => 'hidden',
      '#value' => $subpage,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Delete'),
    ];
    $form['cancel'] = [
      '#type' => 'link',
      '#value' => t('Cancel'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }

    $this->subpagesManager->deleteSubpage($form_state->getValue('node_type'), $form_state->getValue('subpage'));
  }

}
