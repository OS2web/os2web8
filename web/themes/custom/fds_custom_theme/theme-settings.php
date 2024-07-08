<?php

function fds_custom_theme_form_system_theme_settings_alter(
  &$form,
  Drupal\Core\Form\FormStateInterface $form_state
) {
  $form['social']['#access'] = FALSE;

  // Show footer logo.
  $form['logo']['show_footer_logo'] = [
    '#type' => 'checkbox',
    '#title' => t('Show default footer logo.'),
    '#default_value' => theme_get_setting('show_footer_logo'),
  ];
}
