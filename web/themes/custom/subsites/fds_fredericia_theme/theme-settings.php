<?php
use Drupal\Core\Form\FormStateInterface;

function fds_fredericia_theme_form_system_theme_settings_alter(
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

    $font_options = [
        'default' => t('Default Theme Font'),
        'playfair_barlow' => t('Playfair Display for Headings, Barlow for Body Text'),
    ];

// Add a select dropdown for the font combination.

    $form['fds_fredericia_theme_font_combination'] = [
        '#type' => 'select',
        '#title' => t('Font Combination'),
        '#default_value' => theme_get_setting('fds_fredericia_theme_font_combination'),
        '#options' => $font_options,
        '#description' => t('Select the font combination for the theme.')
    ];

    return $form;
}

