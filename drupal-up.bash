# install gd extension and link
sudo apt-get update
sudo apt-get install -y php8.3-gd
ln -s /usr/lib/php/20230831/gd.so /usr/local/php/8.3.14/extensions/
ln -s /usr/share/php8.3-gd/gd/gd.ini /usr/local/php/8.3.14/ini/conf.d/
php -m | grep gd

# install drupal qith sqlliteps
composer create-project drupal/recommended-project:^10 drupal-test 
cd drupal-test
composer require drush/drush 
vendor/bin/drush site:install  --db-url=sqlite://sites/default/files/db.sqlite -y

# configure php
vendor/bin/drush theme:dev on
vendor/bin/drush user-password admin "dru-dev-admin"

# start web server
php -S 0.0.0.0:8080 -t web &
ps -L | grep php


