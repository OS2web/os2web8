<?php

function fds_ringsted_theme_form_system_theme_settings_alter(
  &$form,
  Drupal\Core\Form\FormStateInterface $form_state
) {

  // Texts.
  $form['texts'] = [
    '#type' => 'details',
    '#title' => t('Texts'),
    '#group' => 'fds_base_theme',
  ];
  $form['texts']['frontpage_banner_heading'] = [
    '#type' => 'textfield',
    '#title' => t('Banner overskrift.'),
    '#prefix' => '<h2>' . t('Frontpage') . '</h2>',
    '#default_value' => theme_get_setting('frontpage_banner_heading'),
  ];
  $form['texts']['frontpage_banner_subheading'] = [
    '#type' => 'textfield',
    '#title' => t('Banner underoverskrift.'),
    '#default_value' => theme_get_setting('frontpage_banner_subheading'),
  ];
  $form['contact_information']['vispaakort'] = [
    '#type' => 'textfield',
    '#title' => t('Vis på kort (link)'),
    '#default_value' => theme_get_setting('vispaakort'),
  ];

  $form['options'] = [
    '#type' => 'details',
    '#title' => t('Options'),
    '#group' => 'fds_base_theme',
  ];
  $form['options']['show_last_update'] = [
    '#type' => 'checkbox',
    '#title' => t('Vis sidst opdateret dato på level 2 sider'),
    '#default_value' => theme_get_setting('show_last_update')
  ];
  $form['options']['show_newsletter_action'] = [
    '#type' => 'checkbox',
    '#title' => t('Vis nyhedsbrev tilmelding'),
    '#default_value' => theme_get_setting('show_newsletter_action')
  ];
  $form['options']['top_btn_text'] = [
    '#type' => 'textfield',
    '#title' => t('Skriv titlen på top link knap'),
    '#default_value' => theme_get_setting('top_btn_text')
  ];
  $form['options']['top_btn_url'] = [
    '#type' => 'textfield',
    '#title' => t('Indsæt gyldig url til top link knap'),
    '#default_value' => theme_get_setting('top_btn_url')
  ];
}
