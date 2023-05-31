<?php

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\FormStateInterface;

function fds_fredericia_main_theme_form_system_theme_settings_alter(&$form, Drupal\Core\Form\FormStateInterface $form_state) {
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



    $form['footer']['footer_image_choice'] = [
        '#type' => 'checkbox',
        '#title' => t('Use footer top image'),
        '#default_value' => theme_get_setting('footer_image_choice'),
    ];
    $form['footer']['footer_image_container'] = [
        '#type' => 'container',
        '#states' => [
            'invisible' => [
                'input[name="footer_image_choice"]' => ['checked' => FALSE],
            ],
        ]
    ];
    $form['footer']['footer_image_container']['footer_image_path'] = [
        '#type' => 'textfield',
        '#title' => t('Path to footer image'),
        '#default_value' => theme_get_setting('footer_image_path'),
    ];

    $form['footer']['footer_image_container']['footer_image_upload'] = [
        '#type' => 'file',
        '#title' => t('upload footer image'),
        '#default_value' => theme_get_setting('footer_image_upload'),
        '#element_validate' => array('fds_base_theme_footer_image_validate'),
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
}


function fds_base_theme_footer_image_validate($element, FormStateInterface $form_state)  {
    global $base_url;

    $validators = array('file_validate_is_image' => array());
    $file = file_save_upload('footer_image_upload', $validators, "public://", NULL, FileSystemInterface::EXISTS_REPLACE);
    if (is_array($file)) {
        $file = array_pop($file);
        $file->status = FILE_STATUS_PERMANENT;
        $file->save();

        $uri = $file->getFileUri();
        $form_state->setValue('footer_image_path', $uri);
    }
}