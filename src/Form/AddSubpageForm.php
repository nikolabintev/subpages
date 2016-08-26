<?php

namespace Drupal\subpages\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\subpages\SubpagesManager;

/**
 * Class AddSubpageForm.
 *
 * @package Drupal\subpages\Form
 */
class AddSubpageForm extends FormBase {

  /**
   * Drupal\subpages\SubpagesManager definition.
   *
   * @var \Drupal\subpages\SubpagesManager
   */
  protected $subpagesManager;
  private $node_type;

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
    return 'add_subpage_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node_type = NULL) {
    $this->node_type = $node_type;
    $view_modes = $this->subpagesManager->getViewModes($node_type);

    $form['subpage'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Subpage configuration'),
    ];

    $form['subpage']['title'] = [
      '#title' => $this->t('Title:'),
      '#description' => $this->t('The title of the subpage.'),
      '#type' => 'textfield',
      '#required' => TRUE,
    ];

    $form['subpage']['view_mode'] = [
      '#title' => $this->t('View Mode:'),
      '#type' => 'select',
      '#options' => $view_modes,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save page'
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
    $title = $form_state->getValue('title');
    $view_mode = $form_state->getValue('view_mode');

    $subpage = [
      'title' => $title,
      'view_mode' => $view_mode,
    ];

    $this->subpagesManager->addSubpage($this->node_type, $subpage);
    $form_state->setRedirect('subpages.subpages_controller_subpages', ['node_type' => $this->node_type]);
  }
}
