<?php
namespace Drupal\bc_old_content_notify\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class SettingsForm extends ConfigFormBase
{

  public static $configName = 'bc_old_content_notify.settings';


  public function getFormId() {
    return 'bc_old_content_notify_settings';
  }


  protected function getEditableConfigNames() {
    return [SettingsForm::$configName];
  }


  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config(SettingsForm::$configName);

    $form['form']['enabled'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => ($config->get('enabled') ?? null),
      '#description' => $this->t('Enable this then a cron job is start running on every crontab run with below options ')
    );

    $form['form']['run'] = array(
      '#type' => 'select',
      '#title' => $this->t('running'),
      '#options' => array(
        1 => $this->t('daily'),
        2 => $this->t('weekly'),
        3 => $this->t('monthly'),
        4 => $this->t('yearly'),
      ),
      '#default_value' => ($config->get('run') ?? 3)
    );

    return parent::buildForm($form, $form_state);

  }


  public function submitForm(array &$form, FormStateInterface $form_state) {

    $values = $form_state->getValues();
    $config = $this->config(SettingsForm::$configName);
    foreach ($values as $key => $value) {
      $config->set($key, $value);
    }
    $config->save();

    parent::submitForm($form, $form_state);
  }




}
