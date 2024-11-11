# popular_search_keywords

CONTENTS OF THIS FILE
---------------------

 * INTRODUCTION
 * REQUIREMENTS
 * DEPENDENCIES
 * INSTALLATION
 * CONFIGURATION
 * MAINTAINERS

## INTRODUCTION
This module provides a block with a list of the popular search keywords in the 
site.
It Enables the recording and presentation of statistics for the Search API 
module.
This list can be used for two purposes:
1. Help users to search for popular phrases 
(clueless users can actually find something).
2. Helping site owners to identify popular searches and
optimize the destination pages.

## REQUIREMENTS
- Drupal 8 or Drupal 9

## DEPENDENCIES
Search API module (https://www.drupal.org/project/search_api)

## INSTALLATION
Through Composer
composer require drupal/popular_search_keywords

OR

Through Manually
1. Copy Popular Search Keywords to the modules directory 
of your Drupal installation.
2. Enable the 'Popular Search Keywords' module in 'Extend'.
(/admin/modules)

## CONFIGURATION
1. Module provides a block where you can configure 
"Number of top search phrases to display", 
"Parameter name for the search phrase" and 
"Path of search page".
2. If there is requirement to flush all popular search keywords, 
Click "Flush popular search" button at admin/config/popular-search-keywords.

## MAINTAINERS
Original development: Poorva Rani(https://www.drupal.org/u/poorva)
