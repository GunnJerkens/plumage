# plumage

plum·age (ˈplo͞omij) _noun_ - a bird's feathers collectively.

This is built as a PHP backend replacement for [feather](https://github.com/GunnJerkens/feather). Reasoning for this is that the growth of the old sites with separate diverged building blocks isn't sustainable. This project is meant to be a lightweight relational database that supports multiple projects with a json api.

## setup

Run `composer install` in the root to install all Composer dependencies, then `npm install` to install all Grunt tasks.

### dependencies

- MySql or PostgreSQL
- PHP 5.5+
- node.js & npm
- Composer

### environments

If no environments file exists the application assumes production, If an `.env.local.php` or `.env.staging.php` exists, the application will default to that environment for local and staging respectively.

Each file can contain an array of variables to override for the specific environment, or to keep secret keys out of versioning. The file must at minimum return an array matching the `APP` and `DATABASE` options of the `sample.env.php`.

### grunt

To run the default production build with uglify, compass, browsersync:

```
grunt -v
```

To run the development build that uses concat (for debugging):

```
grunt dev -v
```

## license

MIT
