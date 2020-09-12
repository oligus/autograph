<?php declare(strict_types=1);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('SRC_PATH')) {
    define('SRC_PATH', BASE_PATH . '/src');
}

if (!defined('TEST_PATH')) {
    define('TEST_PATH', BASE_PATH . '/tests');
}

ini_set("display_errors", "1");
error_reporting(E_ALL);

set_include_path(BASE_PATH . PATH_SEPARATOR . get_include_path());

include __DIR__ . "/../vendor/autoload.php";

