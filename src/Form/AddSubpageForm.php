<?php

namespace Drupal\subpages\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\subpages\SubpagesManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AddSubpageForm.
 *
 * @package Drupal\subpages\Form
 */
class AddSubpageForm extends ConfigFormBase {
  private $subpagesManager;

  private $node_type;

  public function __construct(SubpagesManagerInterface $subpagesManager) {
    $this->subpagesManager = $subpagesManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('subpages.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'subpages.AddSubpage',
    ];
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
    $config = $this->config('subpages.AddSubpage');

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

    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $title = $form_state->getValue('title');
    $view_mode = $form_state->getValue('view_mode');

    $subpage = [];
    $subpage[strtolower($title)] = [
      'title' => $title,
      'view_mode' => $view_mode,
    ];

    $this->config('subpages.AddSubpage')
      ->set($this->node_type, $subpage)
      ->save();
  }
}
