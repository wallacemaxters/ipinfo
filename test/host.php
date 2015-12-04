<?php

include __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\IPInfo\IPInfo;


$infos = IPInfo::getFromHost([
	'www.google.com',
	'facebook.com',
	'youtube.com',
]);

print_r($infos);