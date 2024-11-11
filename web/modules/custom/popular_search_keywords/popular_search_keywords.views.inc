<?php

/**
 * @file
 * Popular search.
 */


/**
 * Implements hook_views_data().
 */
function popular_search_keywords_views_data(): array {
  $data['popular_search']['table']['group'] = t('Popular Search Keywords');
  // For other base tables, explain how we join.
  $data['popular_search']['table']['join'] = [
    'users_field_data' => [
      'left_field' => 'uid',
      'field' => 'uid',
    ],
  ];

  $default_int = [
    'field' => [
      'id' => 'standard',
      'click sortable' => TRUE,
    ],
    'filter' => [
      'id' => 'numeric',
    ],
    'argument' => [
      'id' => 'string',
    ],
    'sort' => [
      'id' => 'standard',
    ],
  ];

  $default_string = [
    'field' => [
      'id' => 'standard',
      'click sortable' => TRUE,
    ],
    'filter' => [
      'id' => 'string',
    ],
    'argument' => [
      'id' => 'string',
    ],
    'sort' => [
      'id' => 'standard',
    ],
  ];

  $default_language = [
    'field' => [
      'id' => 'locale_language',
      'click sortable' => TRUE,
    ],
    'filter' => [
      'id' => 'locale_language',
    ],
    'argument' => [
      'id' => 'locale_language',
    ],
  ];

  $default_date = [
    'field' => [
      'id' => 'date',
      'click sortable' => TRUE,
    ],
    'filter' => [
      'id' => 'date',
    ],
    'argument' => [
      'id' => 'date',
    ],
    'sort' => [
      'id' => 'date',
    ],
  ];

  // popular_search table -- fields.
  $data['popular_search']['qid'] = [
      'title' => t('Primary Key'),
      'help' => t('The Search Query ID.'),
    ] + $default_int;

  $data['popular_search']['s_name'] = [
      'title' => t('Server name'),
      'help' => t('Server Name.'),
    ] + $default_string;

  $data['popular_search']['i_name'] = [
      'title' => t('Index machine name'),
      'help' => t('Index machine name'),
    ] + $default_string;

  $data['popular_search']['timestamp'] = [
      'title' => t('Timestamp'),
      'help' => t('Unix timestamp of when query occurred.'),
    ] + $default_date;

  $data['popular_search']['numfound'] = [
      'title' => t('Number of found results'),
      'help' => t('Number of results.'),
    ] + $default_int;

  $data['popular_search']['total_time'] = [
      'title' => t('Total time for the query'),
      'help' => t('Number of results.'),
    ] + $default_int;

  $data['popular_search']['prepare_time'] = [
      'title' => t('Prepare time'),
      'help' => t('Time taken by Search API prepare phase for this query (miliseconds).'),
    ] + $default_int;

  $data['popular_search']['process_time'] = [
      'title' => t('Process time'),
      'help' => t('Time taken by Search API process phase for this query (miliseconds).'),
    ] + $default_int;

  $data['popular_search']['sid'] = [
      'title' => t('Session ID'),
      'help' => t('Session ID of user who triggered the query.'),
    ] + $default_string;

  $data['popular_search']['showed_suggestions'] = [
      'title' => t('Showed suggestions'),
      'help' => t('Indicates whether a spelling suggestion was shown.'),
    ] + $default_int;

  $data['popular_search']['page'] = [
      'title' => t('Page'),
      'help' => t('Current results page.'),
    ] + $default_string;

  $data['popular_search']['keywords'] = [
      'title' => t('Keywords'),
      'help' => t('Query keywords arguments.'),
    ] + $default_string;

  $data['popular_search']['filters'] = [
      'title' => t('Filters'),
      'help' => t('Query filter arguments.'),
    ] + $default_string;

  $data['popular_search']['sort'] = [
      'title' => t('Sort'),
      'help' => t('Query sort arguments.'),
    ] + $default_string;

  if (\Drupal::service('module_handler')->moduleExists('locale')) {
    $data['popular_search']['language'] = [
        'title' => t('Language'),
        'help' => t('Search Language In.'),
      ] + $default_language;
  }
  $data['popular_search']['table']['base'] = [
    'field' => 'qid',
    'title' => t('Popular Search'),
    'help' => t("Popular Search."),
    'weight' => -9,
  ];

  // Relationship to the 'Users' table.
  $data['popular_search']['uid'] = [
    'title' => t('User ID'),
    'help' => t('Relationship to users.'),
    'relationship' => [
      'title' => t('User'),
      'base' => 'users_field_data',
      'base field' => 'uid',
      'id' => 'standard',
    ],
  ];

  return $data;
}
