<?php

ini_set('default_charset', 'utf-8');

require_once __DIR__ . '/vendor/autoload.php';

use WallaceMaxters\IPInfo\IPInfo;


$info = IPInfo::get('189.100.189.32');


print_r($info->toArray());