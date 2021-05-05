#!/bin/sh

echo "Importing new import configuration"
drush cim --partial --source=modules/custom/ballerup_d7_migration/config/install -y
echo "Configuration imported"

echo "Migration users - START"
drush migrate:import ballerup_d7_user
echo "Migration users - END"

echo "Migration ballerup_d7_taxonomy_section - START"
drush migrate:import ballerup_d7_taxonomy_section
echo "Migration ballerup_d7_taxonomy_section - END"

echo "Migration ballerup_d7_taxonomy_tags - START"
drush migrate:import ballerup_d7_taxonomy_tags
echo "Migration ballerup_d7_taxonomy_tags - END"

echo "Migration os2web_borgerdk_articles_import - START"
drush migrate:import os2web_borgerdk_articles_import
echo "Migration os2web_borgerdk_articles_import - END"

echo "Migration ballerup_d7_contact_box - START"
drush migrate:import ballerup_d7_contact_box
echo "Migration ballerup_d7_contact_box - END"

echo "Migration ballerup_d7_paragraph_iframe - START"
drush migrate:import ballerup_d7_paragraph_iframe
echo "Migration ballerup_d7_paragraph_iframe - END"

echo "Migration ballerup_d7_node_gallery_slide - START"
drush migrate:import ballerup_d7_node_gallery_slide
echo "Migration ballerup_d7_node_gallery_slide - END"

echo "Migration ballerup_d7_node_institution_page - START"
drush migrate:import ballerup_d7_node_institution_page
echo "Migration ballerup_d7_node_institution_page - END"

echo "Migration ballerup_d7_node_news - START"
drush migrate:import ballerup_d7_node_news
echo "Migration ballerup_d7_node_news - END"

echo "Migration ballerup_d7_paragraph_accordion - START"
drush migrate:import ballerup_d7_paragraph_accordion
echo "Migration ballerup_d7_paragraph_accordion - END"

echo "Migration ballerup_d7_node_indholdside - START"
drush migrate:import ballerup_d7_node_indholdside
echo "Migration ballerup_d7_node_indholdside - END"

echo "Execuing custom script [1/3] - Fix publish status"
drush scr modules/custom/ballerup_d7_migration/scripts/migrate_fix_publish_status.php
echo "Execuing custom script [2/3] - Remove inline picutres"
drush scr modules/custom/ballerup_d7_migration/scripts/remove_inline_pictures.php
echo "Execuing custom script [3/3] - Remove node header duplicates (content pages using Borger.dk article)"
drush scr modules/custom/ballerup_d7_migration/scripts/BKDK-401-migrate_remove_page_borgerdk_body.php

echo "Migration complete visit URL '/admin/config/system/delete-orphans' to delete the orphaned paragraphs"
