# plumage

This is built as a PHP replacement for Feather (CouchDB).

## environments

If no environments file exists the application assumes production, create `.env.local.php` or `.env.local.php` for local and staging respectively.

Eacho file can contain an array of variables to override for the specific environment, or to keep secret keys out of versioning. The file must at minimum return an empty array.

```
<?php return [];
```

## license

MIT
