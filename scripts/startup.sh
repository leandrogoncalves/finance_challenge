#! /bin/bash

cp .env.example .env
docker-compose exec app bash -c "
chmod 777 /var/www/storage/logs -R;
chmod 777 /var/www/storage/framework -R;
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer;
composer install;
php artisan key:generate;
php artisan migrate;
php artisan db:seed;
php artisan l5-swagger:generate;
php artisan test
"
