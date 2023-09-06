#!/bin/sh

echo "Migration started"

echo "Importing new import configuration"
drush cim --partial --source=modules/custom/fk_d7_migration/config/install -y
echo "Configuration imported"

echo "Migration fk_d7_user - START"
drush migrate:reset fk_d7_user
drush migrate:import fk_d7_user
echo "Migration fk_d7_user - END"

echo "Migration fk_d7_contact_box - START"
drush migrate:reset fk_d7_contact_box
drush migrate:import fk_d7_contact_box
echo "Migration fk_d7_contact_box - END"

echo "Migration fk_d7_taxonomy_section - START"
drush migrate:reset fk_d7_taxonomy_section
drush migrate:import fk_d7_taxonomy_section
echo "Migration fk_d7_taxonomy_section - END"

echo "Migration fk_d7_os2web_contentpage_paragraph_files - START"
drush migrate:reset fk_d7_os2web_contentpage_paragraph_files
drush migrate:import fk_d7_os2web_contentpage_paragraph_files
echo "Migration fk_d7_os2web_contentpage_paragraph_files - END"

echo "Migration fk_d7_node_news - START"
drush migrate:reset fk_d7_node_news
drush migrate:import fk_d7_node_news
echo "Migration fk_d7_node_news - END"

echo "Migration fk_d7_taxonomy_keywords - START"
drush migrate:reset fk_d7_taxonomy_keywords
drush migrate:import fk_d7_taxonomy_keywords
echo "Migration fk_d7_taxonomy_keywords - END"

echo "Migration fk_d7_selfservice - START"
drush migrate:reset fk_d7_selfservice
drush migrate:import fk_d7_selfservice
echo "Migration fk_d7_selfservice - END"

echo "Migration fk_d7_node_indholdside - START"
drush migrate:reset fk_d7_node_indholdside
drush migrate:import fk_d7_node_indholdside
echo "Migration fk_d7_node_indholdside - END"

echo "Migration fk_d7_node_indholdside (updating content reference) - START"
drush migrate:reset fk_d7_node_indholdside
drush migrate:import fk_d7_node_indholdside --update
echo "Migration fk_d7_node_indholdside (updating content reference) - END"

echo "Migration fk_d7_node_borgerdk_indholdside - START"
drush migrate:reset fk_d7_node_borgerdk_indholdside
drush migrate:import fk_d7_node_borgerdk_indholdside
echo "Migration fk_d7_node_borgerdk_indholdside - END"

echo "Migration fk_d7_taxonomy_section_contentpage - START"
drush migrate:reset fk_d7_taxonomy_section_contentpage
drush migrate:import fk_d7_taxonomy_section_contentpage
echo "Migration fk_d7_taxonomy_section_contentpage - END"

echo "Migration fk_d7_main_menu - START"
drush migrate:reset fk_d7_main_menu
drush migrate:import fk_d7_main_menu
echo "Migration fk_d7_main_menu - END"

echo "Migration finished"
