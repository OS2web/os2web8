<?php

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    // Basis farver (påkrævet af color modulet)
    'base' => t('Basis farve'),
    'text' => t('Tekst farve'),
    'link' => t('Link farve'),
    
    // Baggrund farver
    'background_color__default' => t('Baggrund farve - standard'),
    'background_color__primary' => t('Baggrund farve - primær'),
    'background_color__secondary' => t('Baggrund farve - sekundær (med hvid tekst)'),
    'background_color__tertiary' => t('Baggrund farve - tertiær (med hvid tekst)'),
    'background_color__navigation' => t('Baggrund farve - navigation (med hvid tekst)'),
    'background_color__footer_primary' => t('Baggrund farve - sidefod primær (med hvid tekst)'),
    'background_color__footer_secondary' => t('Baggrund farve - sidefod sekundær (med hvid tekst)'),
    
    // Knap farver
    'background_color__button' => t('Baggrund farve - knap'),
    'background_color__button_hover' => t('Baggrund farve - knap:hover'),
    
    // Link farver
    'color__link' => t('Link farve'),
    'color__link__hover' => t('Link farve - hover'),
    'color__link_footer' => t('Link farve - sidefod'),
    
    // Tekst farver
    'color__text' => t('Tekst farve (på lyse baggrunde)'),
    'color__text__light' => t('Tekst farve (på mørke baggrunde)'),
    'color__text__dark' => t('Tekst farve (på meget lyse baggrunde)'),
    'color__text__secondary' => t('Tekst farve - sekundær'),
    
    // Ramme farver
    'color__border' => t('Ramme farve'),
    'color__border__light' => t('Ramme farve - lys'),
    'color__border__dark' => t('Ramme farve - mørk'),
    
    // Navigation farver
    'color__navigation__text' => t('Navigation tekst farve'),
    'color__navigation__text__hover' => t('Navigation tekst farve - hover'),
    'color__navigation__background__hover' => t('Navigation baggrund - hover'),
    'color__navigation__active__text' => t('Navigation tekst farve - aktiv'),
    'color__navigation__active__background' => t('Navigation baggrund - aktiv'),
    
    // Dropdown/Overlay farver
    'color__dropdown__background' => t('Dropdown baggrund'),
    'color__dropdown__shadow__base' => t('Dropdown skygge basis farve'),
    'color__overlay__background__base' => t('Overlejring baggrund basis farve'),
    
    // Sektion variant farver
    'color__section__alert__background' => t('Sektion baggrund - advarsel'),
    'color__section__alert__text' => t('Sektion tekst farve - advarsel'),
    
    // Formular indtastning farver
    'color__input__background' => t('Indtastning baggrund farve'),
    'color__input__text' => t('Indtastning tekst farve'),
    'color__input__border' => t('Indtastning ramme farve'),
    'color__input__placeholder' => t('Indtastning placeholder farve'),
    'color__input__icon' => t('Indtastning ikon farve'),
    
    // Brødkrumme farver
    'color__breadcrumb__separator' => t('Brødkrumme separator farve'),
    
    // Spotbox farver
    'color__spotbox__primary' => t('Spotbox baggrund - primær variant'),
    'color__spotbox__secondary' => t('Spotbox baggrund - sekundær variant'),
    'color__spotbox__tertiary' => t('Spotbox baggrund - tertiær variant'),
    'color__spotbox__text' => t('Spotbox tekst farve'),
    
    // Punkt farver
    'color__bullets' => t('Punkt farve'),
    'bullet_color__primary' => t('Punkt farve primær (50/50 paragraf)'),
    'bullet_color__secondary' => t('Punkt farve sekundær (50/50 paragraf)'),
    'bullet_color__tertiary' => t('Punkt farve tertiær (50/50 paragraf)')
  ],

  // Pre-defined color schemes.
  'schemes' => [
    'default' => [
      'title' => t('Standard (standard)'),
      'colors' => [
        // Basis farver (påkrævet af color modulet)
        'base' => '#454545', // Mørk grå - basis tema farve
        'text' => '#231f20', // Næsten sort - hoved tekst farve
        'link' => '#231f20', // Næsten sort - link farve
        
        // Baggrund farver
        'background_color__default' => '#ffffff', // Hvid - hoved side baggrund
        'background_color__primary' => '#f5f5f5', // Meget lys grå - bokse, kort
        'background_color__secondary' => '#454545', // Mørk grå - sektioner med hvid tekst
        'background_color__tertiary' => '#747474', // Mellem-mørk grå - alternative sektioner
        'background_color__navigation' => '#ffffff', // Hvid - navigation bar
        'background_color__footer_primary' => '#231f20', // Næsten sort - sidefod hoved
        'background_color__footer_secondary' => '#454545', // Mørk grå - sidefod sekundær
        
        // Knap farver
        'background_color__button' => '#454545', // Mørk grå - primære knapper
        'background_color__button_hover' => '#231f20', // Næsten sort - knap hover
        
        // Link farver
        'color__link' => '#231f20', // Næsten sort - links
        'color__link__hover' => '#000000', // Sort - link hover
        'color__link_footer' => '#bfbfbf', // Lys grå - sidefod links (på mørk baggrund)
        
        // Tekst farver
        'color__text' => '#231f20', // Næsten sort - hoved tekst på lyse baggrunde
        'color__text__light' => '#ffffff', // Hvid - tekst på mørke baggrunde
        'color__text__dark' => '#000000', // Sort - tekst på meget lyse baggrunde
        'color__text__secondary' => '#747474', // Mellem-mørk grå - sekundær tekst
        
        // Ramme farver
        'color__border' => '#e6e6e6', // Lys grå - standard rammer
        'color__border__light' => '#eeeeee', // Meget lys grå - subtile rammer
        'color__border__dark' => '#454545', // Mørk grå - fremtrædende rammer
        
        // Navigation farver
        'color__navigation__text' => '#454545', // Mørk grå - navigation link tekst
        'color__navigation__text__hover' => '#231f20', // Næsten sort - navigation hover tekst
        'color__navigation__background__hover' => '#454545', // Mørk grå - navigation hover baggrund
        'color__navigation__active__text' => '#ffffff', // Hvid - aktiv navigation tekst
        'color__navigation__active__background' => '#454545', // Mørk grå - aktiv navigation baggrund
        
        // Dropdown/Overlay farver
        'color__dropdown__background' => '#ffffff', // Hvid - dropdown menu baggrund
        'color__dropdown__shadow__base' => '#1b1b1d', // Mørk grå - basis farve for dropdown skygge
        'color__overlay__background__base' => '#ffffff', // Hvid - basis farve for overlejring baggrunde
        
        // Sektion variant farver
        'color__section__alert__background' => '#747474', // Mellem-mørk grå - advarsel sektion
        'color__section__alert__text' => '#000000', // Sort - advarsel sektion tekst
        
        // Formular indtastning farver
        'color__input__background' => '#ffffff', // Hvid - indtastning baggrund
        'color__input__text' => '#000000', // Sort - indtastning tekst
        'color__input__border' => '#999999', // Mellem grå - indtastning ramme
        'color__input__placeholder' => '#999999', // Mellem grå - placeholder tekst
        'color__input__icon' => '#454545', // Mørk grå - indtastning ikon farve
        
        // Brødkrumme farver
        'color__breadcrumb__separator' => '#555555', // Mellem-mørk grå - brødkrumme separator
        
        // Spotbox farver
        'color__spotbox__primary' => '#454545', // Mørk grå - spotbox primær variant
        'color__spotbox__secondary' => '#747474', // Mellem-mørk grå - spotbox sekundær variant
        'color__spotbox__tertiary' => '#999999', // Mellem grå - spotbox tertiær variant
        'color__spotbox__text' => '#ffffff', // Hvid - spotbox tekst på farvede baggrunde
        
        // Punkt farver
        'color__bullets' => '#454545', // Mørk grå - punkt punkter
        'bullet_color__primary' => '#231f20', // Næsten sort
        'bullet_color__secondary' => '#ffffff', // Hvid
        'bullet_color__tertiary' => '#747474' // Mellem-mørk grå
      ],
    ],
  ],

  // CSS files (excluding @import) to rewrite with new color scheme.
  'css' => [
    'dist/stylesheets/stylesheet.css',
  ],

  // Files to copy.
  'copy' => [
    'logo.svg',
  ],
];
