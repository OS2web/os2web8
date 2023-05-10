<?php
use Drupal\Core\Form\FormStateInterface;

function fds_faxe_theme_form_system_theme_settings_alter(
  &$form,
  Drupal\Core\Form\FormStateInterface $form_state
) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $form['footer']['footer_show_latest_content_header'] = [
    '#prefix' => '<h3>',
    '#markup' => t('Latest content section'),
    '#suffix' => '</h3>',
  ];
  $form['footer']['footer_show_latest_content'] = [
    '#type' => 'checkbox',
    '#title' => t('enable '),
    '#default_value' => theme_get_setting('footer_show_latest_content'),
  ];
  $form['branding'] = [
    '#type' => 'details',
    '#title' => t('Branding'),
    '#group' => 'fds_base_theme',
  ];
  $form['branding']['branding_toggle'] = [
    '#type' => 'checkbox',
    '#title' => t('Vis branding'),
    '#default_value' => theme_get_setting('branding_toggle'),
  ];
  $form['branding']['branding_text'] = [
    '#type' => 'textfield',
    '#title' => t('Tekst'),
    '#default_value' => theme_get_setting('branding_text'),
  ];

  // Add a vertical tab for custom theme settings.
  $form['fds_faxe_theme_settings'] = [
    '#type' => 'vertical_tabs',
    '#title' => t('Banner Search settings'),
    '#weight' => -10,
  ];

  // Add the image upload field.
  $form['fds_faxe_theme_settings']['fds_faxe_theme_background_image'] = [
    '#type' => 'managed_file',
    '#title' => t('Background Image'),
    '#description' => t('Upload the background image for the block.'),
    '#default_value' => theme_get_setting('fds_faxe_theme_background_image'),
    '#upload_location' => 'public://fds_faxe_theme/background-images/',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
    ],
  ];
}
