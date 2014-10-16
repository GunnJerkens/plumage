# plumage

This is built as a PHP replacement for Feather (CouchDB).

## setup

Run `composer install` in the root to install all Composer dependencies, then `npm install` to install all Grunt tasks.

### dependencies

- MySql or PostgreSQL
- PHP 5.5+
- Node.js & NPM
- Composer

### environments

If no environments file exists the application assumes production, create an `.env.local.php` or `.env.local.php` for local and staging respectively.

Eacho file can contain an array of variables to override for the specific environment, or to keep secret keys out of versioning. The file must at minimum return an empty array.

```
<?php return [];
```

## license

MIT
