<?php

namespace Drupal\os2web_edoc_file_import\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'os2web_edoc_file_import_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['os2web_edoc_file_import.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('os2web_edoc_file_import.settings');

    $form['import_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Import sti'),
      '#default_value' => $config->get('import_path'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('os2web_edoc_file_import.settings')
      ->set('import_path', $form_state->getValue('import_path'))
      ->save();

    $this->messenger()->addMessage($this->t('Configuration saved.'));
  }

}
