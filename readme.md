# plumage

![Travis Build Status](https://travis-ci.org/GunnJerkens/plumage.svg?branch=master)

![Plumage Logo](https://raw.githubusercontent.com/GunnJerkens/plumage/master/public/img/logo.png)

plum·age (ˈplo͞omij) _noun_ - a bird's feathers collectively.

The core concept behind this project is to build a lightweight API that is easily customizable, has user accounts to allow editing by end clients/users, and is handled entirely using a relational schema.  

Plumage is built as a relational API replacement for [feather](https://github.com/GunnJerkens/feather) [deprecated].  

## setup

Run `composer install` in the root to install all Composer dependencies, then `npm install` to install all Grunt tasks. Create a MySql/PostgreSQL database and configure your environments file with your specific configuration.

### environments

If no environments file exists the application assumes production, if an `.env.local.php` or `.env.staging.php` exists, the application will default to that environment for local and staging respectively. Use `.env.php` for your production environments file.  

[Laravel Configuration Docs](http://laravel.com/docs/4.2/configuration)  

Each file can contain an array of variables to override for the specific environment, or to keep secret keys out of versioning. The file must at minimum return an array matching the `APP` and `DATABASE` options of the `sample.env.php`.  

### seeding

To use the default seed data run `bin/reset.sh`. Credentials can be found in `app/database/seeds/UserTableSeeder.php` to login.

### scripts

To setup project scripts for database pulls and cronjobs, copy `bin/config.sample.sh` to `bin/config.sh` and fill out all required values.

Run `bin/db_fetch.sh` to clone a remote database to the local environment. Use `bin/db_backup.sh` to dump the current database and save to the configured sql directory.

### development

To run the default production build with uglify, compass, browsersync use `grunt -v`. To run the development build that uses concat (for debugging) use `grunt dev -v`.

All pull requests should made on the `master` branch.

## dependencies

- MySql or PostgreSQL
- PHP 5.5+
- node.js & npm
- Composer

## PHP settings

Set `max_input_vars` to at least `10000` or else you won't be able to save edits to the seed data.

## issues

[Open Issues](https://github.com/GunnJerkens/plumage/issues)

*** Bin scripts do not currently support Postgres ***

## license

MIT
