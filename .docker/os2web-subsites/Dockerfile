ARG TAG

# OS2Web subsites image is based on OS2Web image
FROM dkbellcom/os2web8:$TAG

# Installing additional dependencies.
RUN set -eux; \
	apt update; \
	apt install -qq -y \
		pwgen \
		zip \
		cron \
		sudo; \
	rm -rf /var/lib/apt/lists/*

# Adding further site specific data to image.
RUN chown -R www-data:www-data /opt/drupal/tmp /opt/drupal/logs /opt/drupal/translations; \
	echo "<?php" > /opt/drupal/web/sites/sites.php; \
	chmod g+s -R /opt/drupal/private /opt/drupal/web/sites /opt/drupal/translations /opt/drupal/web/sites/sites.php

# Additional PHP configuration for OS2Web subsites both CLI and Apache
COPY php/os2web-subsites.ini /usr/local/etc/php/conf.d/os2web-subsites.ini

# Adding entry point where required services could be started.
COPY entrypoint.sh /usr/bin/

# Settings correct permissions.
RUN chmod +x /usr/bin/entrypoint.sh

# Adding missing HOME env variable.
# By some circumstances this variable is not availabe on subsite create process.
RUN echo "HOME=/opt/drupal" >> /opt/drupal/.env

# Addjusting php runtime.
RUN ln -s /usr/local/bin/php /usr/bin/php;

ENTRYPOINT ["entrypoint.sh"]

CMD ["apache2-foreground"]
