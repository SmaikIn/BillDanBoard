#!/bin/bash

# Run project
docker exec -it laravel sh -c "composer install"
docker exec -it laravel sh -c "php artisan key:generate"
docker exec -it laravel sh -c "php artisan migrate"
docker exec -it laravel sh -c "php artisan db:seed"

# Fix volume permissions
docker exec -it laravel sh -c "chmod 777 /var/www/html/storage/logs"
docker exec -it laravel sh -c "chmod 777 /var/www/html/storage/framework/views"
