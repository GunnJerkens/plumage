#!/bin/sh

echo 'drop database plumage_dev; create database plumage_dev;' | mysql -uroot

php artisan migrate:install
php artisan migrate --package=cartalyst/sentry
php artisan migrate
php artisan db:seed