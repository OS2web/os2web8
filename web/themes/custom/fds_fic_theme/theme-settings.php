<?php

use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Form\FormStateInterface;

function fds_fic_theme_form_system_theme_settings_alter(&$form, Drupal\Core\Form\FormStateInterface $form_state) {
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

    $form['footer']['footer_image_container']['footer_image_alt_text'] = [
        '#type' => 'textfield',
        '#title' => t('Footer image alt text'),
        '#default_value' => theme_get_setting('footer_image_alt_text'),
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


  $theme_settings = \Drupal::configFactory()->getEditable('fds_fic_theme.settings');
  $form['banner_image'] = [
    '#type' => 'managed_file',
    '#title' => t('Banner Image'),
    '#description' => t('Upload an image for the banner section.'),
    '#default_value' => $theme_settings->get('banner_image'),
    '#upload_location' => 'public://fds_fic_theme/images/',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
    ],
  ];
  $form['placeholder_images'] = [
    '#type' => 'managed_file',
    '#title' => t('Nyheder Placeholder Images'),
    '#description' => t('Upload images to be used as placeholders for news articles.'),
    '#default_value' => $theme_settings->get('placeholder_images'),
    '#upload_location' => 'public://fds_fic_theme/images/',
    '#upload_validators' => [
      'file_validate_extensions' => ['png gif jpg jpeg'],
    ],
    '#multiple' => TRUE, // Allow multiple file uploads
  ];

  $form['#submit'][] = 'fds_fic_theme_custom_theme_settings_submit';


  $form['selfservice_link_text'] = [
    '#type' => 'textfield',
    '#title' => t('Selvbetjening Link Tekst'),
    '#default_value' => theme_get_setting('selfservice_link_text'),
    '#description' => t('Indtast linkteksten for knappen i selvbetjening sidebaren.'),
  ];

  // Define a field for the link URL
  $form['selfservice_link_url'] = [
    '#type' => 'textfield',
    '#title' => t('Selvbetjening Link URL'),
    '#default_value' => theme_get_setting('selfservice_link_url'),
    '#description' => t('Indtast link URL for knappen i selvbetjening sidebaren.'),
  ];

  $form['book_link_url'] = [
    '#type' => 'textfield',
    '#title' => t('Book knap Link URL'),
    '#default_value' => theme_get_setting('book_link_url'),
    '#description' => t('Indsøt link URL for book knappen i top navigationen.')
  ];

  $form['book_button_label'] = [
    '#type' => 'textfield',
    '#title' => t('Book knap label'),
    '#default_value' => theme_get_setting('book_button_label'),
    '#description' => t('Teksten i knappen'),
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

function fds_fic_theme_custom_theme_settings_submit(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  // Get the uploaded file's fid from the form state.
  $file_fid = $form_state->getValue('banner_image');

  // Check if a file was uploaded.
  if (!empty($file_fid)) {
    // Load the file entity.
    $file = \Drupal\file\Entity\File::load($file_fid[0]);

    // Check if the file entity exists.
    if ($file) {
      // Set the file status to "Permanent."
      $file->setPermanent();
      $file->save();
    }
  }
  $placeholder_fids = $form_state->getValue('placeholder_images');
  if (!empty($placeholder_fids)) {
    foreach ($placeholder_fids as $fid) {
      $file = \Drupal\file\Entity\File::load($fid);
      if ($file) {
        $file->setPermanent();
        $file->save();
      }
    }
  }
}
