# Helbreath Fury site

PHP site: news (added, modified and deleted by the admin), Register and Cash Shop pages (forms only, not wired
to a game database yet).

- **Live (home server):** https://kazin.dev/hbsite/, files in `/var/www/hbsite` on `kazin-music`, served by
  Caddy (`/etc/caddy/sites/kazin.dev.d/hbsite.caddy`) through php-fpm, MySQL database `hbsite`.
- **Settings:** `config.php` (git-ignored; copy `config.sample.php`): the database and the admin password's hash
  (`php -r "echo password_hash('<password>', PASSWORD_DEFAULT);"`). The server keeps its own.
- **Database:** `schema.sql` (safe to run again).
- **Admin:** `admin.php` logs in; then Home shows Add / Modify / Delete on the news.
- **Deploy:** `powershell -ExecutionPolicy Bypass -File deploy.ps1` uploads the tracked files to the server
  (never `config.php`).
