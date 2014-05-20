<?php
define('DEBUG_MODE', true);

define('DB_DSN', 'mysql:dbname=class_b host=localhost port=3306');
define('DB_USERNAME', 'class_b');
define('DB_PASSWORD', 'qwerty');

define('DEFAULT_LANG', 'bg');

$CONFIG['default_lang'] = DEFAULT_LANG;
$CONFIG['summaryTextSize'] = 350;

$CONFIG['dateFormat'] = 'YYYY-MM-DD';
$CONFIG['timestampFormat'] = 'YYYY-MM-DD HH24:MI';

mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");

?>