<?php


require_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\IPInfo\IPInfo;


$info = IPInfo::get(['208.0.0.5', '192.1.1.1']);

echo '<pre>';

print_r($info);