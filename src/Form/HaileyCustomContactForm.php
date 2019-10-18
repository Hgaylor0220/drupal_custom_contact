<?php

namespace Drupal\drupal_custom_contact\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannelFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Language\LanguageManager;

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

    $form['contact_message'] = array (
      '#type' => 'textarea',
      '#title' => t('Message'),
    );

    $form['human_catcher'] = array(
      '#type' => 'textfield',
      '#title' => t('A human says "what"?'),
      '#required' => TRUE,
    );

    $form['robot_catcher'] = array(
      '#type' => 'textfield',
      '#title' => t('A robot says something, people say nothing!'),
      '#required' => FALSE,
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
    $values = $form_state->getValues();

    if ($values['human_catcher'] != "what" ) {
      $form_state->setErrorByName(
        "hunan_catcher",
        "Thats not what a human says, a human says 'what'."
      );
    }

    if (strlen($values['robot_catcher']) > 0 ) {
      $form_state->setErrorByName(
        'robot_catcher',
        "Humans shouldnt say anything."
      );
    }


  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $values = $form_state->getValues();

    $mailManager = \Drupal::service('plugin.manager.mail');
    $module = 'drupal_custom_contact';
    $key = 'custom_contact';
    $to = 'haileygaylor@gmail.com';

    $params['contact_name'] = $values['contact_name'];
    $params['contact_mail'] = $values['contact_mail'];
    $params['contact_message'] = $values['contact_message'];
    $langcode = \Drupal::currentUser()->getPreferredLangcode();

    $result = $mailManager->mail(
      $module,
      $key,
      $to,
      $langcode,
      $params,
      NULL,
      TRUE
    );

    if ($result['result'] !== true) {
     drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
    }
    else {
     drupal_set_message(t('Your message has been sent! Hailey will get back to you as soon as possbile!'));
    }
  }

}
