#!/bin/sh

echo "Migration started"

echo "Importing new import configuration"
drush cim --partial --source=modules/custom/faxe_d7_migration/config/install -y
echo "Configuration imported"

echo "Migration faxe_d7_paragraph_banner - START"
drush migrate:import faxe_d7_paragraph_banner
echo "Migration faxe_d7_paragraph_banner - END"

echo "Migration finished"
