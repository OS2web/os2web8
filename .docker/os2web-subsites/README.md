# OS2Web-subsites docker image

Image based on official [Drupal image](https://hub.docker.com/_/drupal)

Image includes all functional project files inside (PHP code, Composer dependencies).

Drupal content files should be attached as [Volumes](https://docs.docker.com/storage/volumes/) to container:
* private files - `/opt/drupal/private`
* sites - `/opt/drupal/web/sites`
* apache sites-availbale - `/etc/apache/sites-availbale`
* apache sites-enabled - `/etc/apache/sites-enabled`
* sites config storage - `/opt/drupal/config`
* cron jobs - `/var/spool/cron/crontabs`

## Build image

To build image use `build.sh` script with git tag of OS2Web project release as first argument.
NOTE: You should have existing tag for OS2Web project before.

Example:
```
./build.sh [tag-name] --push
```

`--push` - when you this option build will be pushed to docker hub.
