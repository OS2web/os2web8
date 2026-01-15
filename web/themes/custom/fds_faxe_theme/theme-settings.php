<?php
use Drupal\Core\Form\FormStateInterface;

function fds_faxe_theme_form_system_theme_settings_alter(&$form, Drupal\Core\Form\FormStateInterface $form_state) {
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

  $form['silktide_cookie_banner'] = [
    '#type' => 'details',
    '#title' => t('Silktide Cookie Consent Banner'),
    '#open' => TRUE,
  ];

  // Add custom submit handler for file handling
  $form['#submit'][] = 'fds_faxe_theme_custom_theme_settings_submit';


  $form['silktide_cookie_banner']['silktide_enabled'] = [
    '#type' => 'checkbox',
    '#title' => t('Aktivér Silktide Cookie Banner'),
    '#default_value' => theme_get_setting('silktide_enabled'),
    '#description' => t('Check denne boks for at aktivere Silktide Cookie Banner på siden.'),
  ];
  
  // Add file upload field for the CSS file.
  $form['silktide_cookie_banner']['silktide_css_fid'] = [
    '#type' => 'managed_file',
    '#title' => t('Silktide CSS Fil'),
    '#description' => t('Upload Silktide CSS filen her.'),
    '#default_value' => theme_get_setting('silktide_css_fid'),
    '#upload_location' => 'public://silktide_assets/',
    '#upload_validators' => [
      'file_validate_extensions' => ['css'],
    ],
    '#states' => [
      'visible' => [
        ':input[name="silktide_enabled"]' => ['checked' => TRUE],
      ],
    ],
    '#progress_message' => t('Vent venligst...'),
  ];


  $form['silktide_cookie_banner']['silktide_config_script'] = [
    '#type' => 'textarea',
    '#title' => t('Silktide Konfiguration Script'),
    '#default_value' => theme_get_setting('silktide_config_script'),
    '#description' => t('Indsæt Silktide script her.'),
    '#states' => [
      'visible' => [
        ':input[name="silktide_enabled"]' => ['checked' => TRUE],
      ],
    ],
  ];
}
