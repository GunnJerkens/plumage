# plumage

This is built as a PHP replacement for Feather (CouchDB).

## setup

Run `composer install` in the root to install all Composer dependencies, then `npm install` to install all Grunt tasks.

### dependencies

- MySql or PostgreSQL
- PHP 5.5+
- node.js & npm
- Composer

### environments

If no environments file exists the application assumes production, create an `.env.local.php` or `.env.local.php` for local and staging respectively.

Each file can contain an array of variables to override for the specific environment, or to keep secret keys out of versioning. The file must at minimum return an empty array.

```
<?php return [];
```

### grunt

To run the default production build with uglify and compass:

```
grunt -v
```

To run the development build that uses concat and browserSync:

```
grunt dev -v
```

## license

MIT
