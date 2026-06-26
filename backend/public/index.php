<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// ponytail: keep PHP notices/deprecations out of the HTTP body (PHP 8.5 deprecates
// PDO::MYSQL_ATTR_SSL_CA used in framework config, fired before Laravel sets this off).
// Matches production; drop if Laravel/PHP stop emitting it.
ini_set('display_errors', '0');

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
