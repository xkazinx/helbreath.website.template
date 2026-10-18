<?php
// The site's settings. Copy this file to config.php (git-ignored) and fill it in.
return [
  // The MySQL database with the `news` table (schema.sql)
  'db' => [
    'host' => '127.0.0.1',
    'port' => 3307,
    'user' => 'root',
    'pass' => 'root',
    'name' => 'hbsite',
  ],

  // admin.php's password, as a hash: php -r "echo password_hash('<password>', PASSWORD_DEFAULT);"
  'admin_hash' => '',
];
