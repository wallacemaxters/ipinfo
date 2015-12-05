# IPInfo - Easy PHP Library for ipinfo.io

Instalation

```json
{
	"require" : {
		"wallacemaxters/ipinfo" : "1.*"
	}
}

```

```php
use WallaceMaxters\IPInfo\IPInfo;
```
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


Converting information to array
```php
IPInfo::get('8.8.8.8')->toArray();
```

Retrieves information from host(s)

```php
$data = IPInfo::getFromHost('www.google.com');
``` 