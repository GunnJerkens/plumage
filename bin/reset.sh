#!/bin/bash

. `dirname $0`/bootstrap.sh

echo "drop database $env_database; create database $env_database;" | mysql -u$env_username -p$env_password $env_database

php artisan migrate:install
php artisan migrate --package=cartalyst/sentry
php artisan migrate
php artisan db:seed
