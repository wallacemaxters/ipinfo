# IPInfo - Easy PHP Library for ipinfo.io

Get the response of ipinfo.io.
This returns the `\WallaceMaxters\IPInfo\Response` object;
```php
$responseObject = IPInfo::get('8.8.8.8');

```

Get a collection of a response of `\WallaceMaxters\IPInfo\Response`
```php
$ipCollection = IPInfo::get(['8.8.8.8', '7.7.7.7']);
```


Get Lat and Lng separated in array. This results are converted in `float`

```php

list($lat, $lng) = IPInfo::get('8.8.8.8')->getLoc();

```
