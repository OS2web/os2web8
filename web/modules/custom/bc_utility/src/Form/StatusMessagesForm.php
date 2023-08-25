<?php

namespace Drupal\bc_utility\Form;

use Drupal\bc_speed_admin\Form\SettingsForm;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure bc speed admin settings for this site.
 */
class StatusMessagesForm extends ConfigFormBase {

  public static $configName = 'bc_utility_status_messages.settings';


  /**

   * {@inheritdoc}
   */
  public function getFormId() {
    return 'bc_utility_status_messages_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [StatusMessagesForm::$configName];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['statusmessage']['status'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('hide all status messages backend.'),
      '#default_value' => $this->config(StatusMessagesForm::$configName)->get('status')
    );

    $form['statusmessage']['warning'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('hide all warning messages backend.'),
      '#default_value' => $this->config(StatusMessagesForm::$configName)->get('warning')
    );

    $form['statusmessage']['error'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('hide all error messages backend.'),
      '#default_value' => $this->config(StatusMessagesForm::$configName)->get('error')
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config(StatusMessagesForm::$configName);
    foreach ($values as $key => $value) {
      $config->set($key, $value);
    }

    $config->save();

    parent::submitForm($form, $form_state);
  }


}

