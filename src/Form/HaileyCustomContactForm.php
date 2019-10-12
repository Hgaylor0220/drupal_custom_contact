<?php

namespace Drupal\drupal_custom_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

/**
 * Custom Contact Form for Haileys portfolio.
 *
 * Review for how to:
 * https://www.valuebound.com/resources/blog/step-by-step-method-to-create-a-custom-form-in-drupal-8
 *
 * Review for Elements:
 * https://api.drupal.org/api/drupal/elements/8.7.x
 */
class HaileyCustomContactForm extends FormBase implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public function __construct(LoggerChannelFactory $logger) {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Load the services required to construct this class.
    return new static(
      $container->get('logger.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'drupal_custom_contact';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['contact_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Your Name:'),
      '#required' => TRUE,
    );

    $form['contact_mail'] = array(
      '#type' => 'email',
      '#title' => t('Your Email:'),
      '#required' => TRUE,
    );

    $form['contact_number'] = array (
      '#type' => 'tel',
      '#title' => t('Your Number For a callback (optional)'),
    );

    $form['contact_number'] = array (
      '#type' => 'textarea',
      '#title' => t('Message'),
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Contact Hailey'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // @TODO: Check that a legitimate email address was submitted.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    dpm('Form has submitted succesfully!');
  }

}
