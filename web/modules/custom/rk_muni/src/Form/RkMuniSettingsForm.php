<?php

namespace Drupal\rk_muni\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RkMuniSettingsForm extends ConfigFormBase {

/**
* {@inheritdoc}
*/
protected function getEditableConfigNames() {
    return ['rk_muni.settings'];
}

/**
* {@inheritdoc}
*/
public function getFormId() {
    return 'rk_muni_settings_form';
}

/**
* {@inheritdoc}
*/
public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = $this->config('rk_muni.settings');

    $form['rk_muni_script_settings_form'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Muni script settings'),
    ];

   $form['rk_muni_script_settings_form']['rk_muni_script_settings_form_script_code'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Muni script code for the html header'),
       // Use Html::escape() so the HTML code is rendered safely in the form without executing!
      '#default_value' => $config->get('rk_muni_script_settings_form_script_code'),
      '#description' => $this->t('Insert the muni script code provided by the muni team.'),
      '#rows' => 6,
    ];

    $form['rk_muni_script_settings_form_enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Is the script enabled on the site?'),
        '#default_value' => $config->get('rk_muni_script_settings_form_enabled'),
        '#description' => $this->t('Wheter you want the script to be enabled or not.'),
    ];

    return parent::buildForm($form, $form_state);
}

/**
* {@inheritdoc}
*/
public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    // Add custom validation logic if needed.
}

/**
* {@inheritdoc}
*/
public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('rk_muni.settings')
        ->set('rk_muni_script_settings_form_script_code', $form_state->getValue('rk_muni_script_settings_form_script_code'))
        ->set('rk_muni_script_settings_form_enabled', $form_state->getValue('rk_muni_script_settings_form_enabled'))
        ->save();
         
        parent::submitForm($form, $form_state);
    }

}