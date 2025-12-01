<?php

namespace Drupal\rk_head_tags\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class RkHeadTagsSettingsForm extends ConfigFormBase {

/**
* {@inheritdoc}
*/
protected function getEditableConfigNames() {
    return ['rk_head_tags.settings'];
}

/**
* {@inheritdoc}
*/
public function getFormId() {
    return 'rk_head_tags';
}

/**
* {@inheritdoc}
*/
public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = $this->config('rk_head_tags.settings');

    $form['rk_head_tags_acquia_script_settings_form'] = [
        '#type' => 'fieldset',
        '#title' => $this->t('Acquia script settings'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_token'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Acquia script token to be used on this site'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_token'),
        '#description' => $this->t('Inside Acquia administration, go find the script to implement, and locate the token value. Insert the token value here.'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Is the script enabled on the site?'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_enabled'),
        '#description' => $this->t('Wheter you want the script to be enabled or not.'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_cookie_less_tracking'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Cookie less tracking?'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_cookie_less_tracking'),
        '#description' => $this->t('Should Acquia use cookie less tracking?'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_document_tracking_enabled'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Document tracking?'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_document_tracking_enabled'),
        '#description' => $this->t('Should Acquia track documents?'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_document_extensions'] = [
        '#type' => 'textfield',
        '#title' => $this->t('If document tracking is enabled, what file extensions should be tracked? ("PDF","pdf","doc","DOC","docx","DOCX","xls","XLSX","XLS","xlsx")'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_document_extensions'),
        '#description' => $this->t('Define which document types to track.'),
    ];

    $form['rk_head_tags_acquia_script_settings_form_script_path'] = [
        '#type' => 'textfield',
        '#title' => $this->t('What is the script src path? example when the module was build (https://app-script.monsido.com/v2/monsido-script.js)'),
        '#default_value' => $config->get('rk_head_tags_acquia_script_settings_form_script_path'),
        '#description' => $this->t('On the settings page on Acquia admin settings where the script code is located, find the src URL there.'),
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
   

    $this->config('rk_head_tags.settings')
        ->set('rk_head_tags_acquia_script_settings_form_token', $form_state->getValue('rk_head_tags_acquia_script_settings_form_token'))
        ->set('rk_head_tags_acquia_script_settings_form_enabled', $form_state->getValue('rk_head_tags_acquia_script_settings_form_enabled'))
        ->set('rk_head_tags_acquia_script_settings_form_cookie_less_tracking', $form_state->getValue('rk_head_tags_acquia_script_settings_form_cookie_less_tracking'))
        ->set('rk_head_tags_acquia_script_settings_form_document_tracking_enabled', $form_state->getValue('rk_head_tags_acquia_script_settings_form_document_tracking_enabled'))
        ->set('rk_head_tags_acquia_script_settings_form_document_extensions', $form_state->getValue('rk_head_tags_acquia_script_settings_form_document_extensions'))
        ->set('rk_head_tags_acquia_script_settings_form_script_path', $form_state->getValue('rk_head_tags_acquia_script_settings_form_script_path'))
        ->save();
         
        parent::submitForm($form, $form_state);
    }

}