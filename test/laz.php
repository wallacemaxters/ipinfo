<?php

include __DIR__ . '/../vendor/autoload.php';

use WallaceMaxters\IPInfo\IPInfo;
use WallaceMaxters\IPInfo\LazyCollection;



$lazy = new LazyCollection;

$lazy->addFromIP('8.8.8.8');

$lazy->addFromIP('8.8.8.5');

$lazy->addFromIP('8.8.8.6');

foreach ($lazy as $ipinfo) {
	
	print_r($ipinfo->getResponse());
}