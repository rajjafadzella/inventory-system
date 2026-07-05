#!/bin/sh
set -e

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting PHP-FPM..."
php-fpm &

echo "Waiting for PHP-FPM to be ready..."
sleep 2

echo "Starting Nginx..."
exec nginx -g 'daemon off;'
