# install gd extension and link
sudo apt-get update
sudo apt-get install -y php8.3-gd
ln -s /usr/lib/php/20230831/gd.so /usr/local/php/8.3.14/extensions/
php -m | grep gd

# install drupal qith sqllite
composer create-project drupal/recommended-project:^10 drupal-test 
cd drupal-test
composer require drush/drush 
vendor/bin/drush site:install  --db-url=sqlite://sites/default/files/db.sqlite -y

# start web server
php -S 0.0.0.0:8080 -t web

