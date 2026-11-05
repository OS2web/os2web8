<?php

function fds_rebild_theme_form_system_theme_settings_alter(
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

  // Base theme sets #maxlength on a file field; that makes FormValidator call
  // mb_strlen() on an array during upload and fatals on PHP 8+.
  if (isset($form['footer']['logo_settings']['footer_logo_upload']['#maxlength'])) {
    unset($form['footer']['logo_settings']['footer_logo_upload']['#maxlength']);
  }
}
