<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('URL', 'http://'.$_SERVER['HTTP_HOST'].'/');
//define('URL', 'https://'.$_SERVER['HTTP_HOST'].'/');
define('LIBS', 'libs/');
define('UTILS', 'util/');
define('NAME', 'Oseberg');
define('ABOUT', 'Oseberg Api');
define('ROOT',dirname(__FILE__));


define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'oseberg_ose');
define('DB_USER', 'oseberg_ose');
define('DB_PASS', 'admin01');

// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'key_hash_oseberg');

// This is for database passwords only
define('HASH_PASSWORD_KEY', '10-9-8-7-6-5-4-3-2-1hereisrinnasyourall');
header('Access-Control-Allow-Headers: X-Requested-With, origin, content-type');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);