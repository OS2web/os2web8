#!/bin/bash

# Starting cron service.
service cron start

# Check basic file structure for subsites creator
if [ ! -d "/opt/drupal/web/sites/default" ]
then
  echo "Default sites folder doesn't exists. Create folder and standard files"
  mkdir -p /opt/drupal/web/sites/default/files
  cp -f /opt/drupal/.docker/os2web-subsites/settings/default.settings.php /opt/drupal/web/sites/default/default.settings.php
  cp -f /opt/drupal/.docker/os2web-subsites/settings/default.settings.php /opt/drupal/web/sites/default/settings.php
  echo 'include $app_root . "/" . $site_path . "/settings.local.php";' >> /opt/drupal/web/sites/default/settings.php
  cp -f /opt/drupal/.docker/os2web-subsites/settings/settings.local.php /opt/drupal/web/sites/default/settings.local.php
  chmod 755 /opt/drupal/web/sites/default /opt/drupal/web/sites/default/settings.php /opt/drupal/web/sites/default/settings.local.php
  chown -R www-data:www-data /opt/drupal/web/sites
fi

# Copying shared settings file
cp -f /opt/drupal/.docker/os2web-subsites/settings/shared.settings.php /opt/drupal/web/sites/shared.settings.php

exec "$@"
