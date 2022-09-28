#!/bin/sh

echo "Migration started"

echo "Importing new import configuration"
drush cim --partial --source=modules/custom/faxe_d7_migration/config/install -y
echo "Configuration imported"

echo "Migration faxe_d7_paragraph_banner - START"
drush migrate:import faxe_d7_paragraph_banner
echo "Migration faxe_d7_paragraph_banner - END"

echo "Migration faxe_d7_contact_box - START"
drush migrate:import faxe_d7_contact_box
echo "Migration faxe_d7_contact_box - END"

echo "Migration faxe_d7_os2web_contentpage_paragraph_files - START"
drush migrate:import faxe_d7_os2web_contentpage_paragraph_files
echo "Migration faxe_d7_os2web_contentpage_paragraph_files - END"

echo "Migration faxe_d7_paragraph_simple_text - START"
drush migrate:import faxe_d7_paragraph_simple_text
echo "Migration faxe_d7_paragraph_simple_text - END"

echo "Migration faxe_d7_spotbox - START"
drush migrate:import faxe_d7_spotbox
echo "Migration faxe_d7_spotbox - END"

echo "Migration faxe_d7_node_indholdside - START"
drush migrate:import faxe_d7_node_indholdside
echo "Migration faxe_d7_node_indholdside - END"

# We need to run it again in the end, so that the URL's in the fields are transformed into correct node links
echo "Migration faxe_d7_paragraph_banner - START"
drush migrate:import faxe_d7_paragraph_banner --update
echo "Migration faxe_d7_paragraph_banner - END"

echo "Migration finished"
