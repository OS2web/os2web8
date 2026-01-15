<?php

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    // Add 'base' here to satisfy the module's internal logic
    'base' => t('Base theme color'), 
    'background_color__default' => t('Background color - default'),
    'background_color__primary' => t('Background color - primary'),
    'background_color__secondary' => t('Background color - secondary (has white text)'),
  ],

  // Pre-defined color schemes.
  'schemes' => [
    'default' => [
      'title' => t('Standard (default)'),
      'colors' => [
        // Ensure 'base' has a value here as well
        'base' => '#007ca3', 
        'background_color__default' => '#007ca3',
        'background_color__primary' => '#007ca3',
        'background_color__secondary' => '#4195b2',
      ],
    ],
  ],

  // CSS files to rewrite
  'css' => [
    'dist/stylesheets/stylesheet.css',
  ],

  'copy' => [
    'logo.svg',
  ],
];