<?php

$info = [
  'fields' => [
    'base' => t('Base color'),
    'text' => t('Text color'),
    'link' => t('Link color'),
    'background_color__default' => t('Background color - default'),
    'background_color__primary' => t('Background color - primary'),
    'background_color__secondary' => t('Background color - secondary (has white text)'),
  ],

  'schemes' => [
    'default' => [
      'title' => t('Standard (default)'),
      'colors' => [
        'base' => '#007ca3',
        'text' => '#222222', // Added to prevent the "text" error
        'link' => '#007ca3', // Added to prevent the "link" error
        'background_color__default' => '#007ca3',
        'background_color__primary' => '#007ca3',
        'background_color__secondary' => '#4195b2',
      ],
    ],
  ],

  'css' => [
    'dist/stylesheets/stylesheet.css',
  ],

  'copy' => [
    'logo.svg',
  ],
];