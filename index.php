<?php


class Collection implements IteratorAggregate
{
	protected $items = [];
	
	public function __construct(array $ips)
	{
		foreach ($ips as $ip) {
			
			if ($ip instanceof IPInfo) {
				
				$this->items[$ip->getIP()] = $ip->getResponse();
				
				continue;
			}
			
			$this->items[$ip] = (new IPInfo($ip))->getResponse();
		}
	}
	
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
	
}

class Response implements ArrayAccess
{
	protected $infos = [];
	
	public function __construct(array $infos)
	{
		$this->infos = $infos;
	}
	
	public function offsetSet($key, $value)
	{
		throw new RunTimeException('Disabled');
	}
	
	public function offsetGet($key)
	{
		return $this->offsetExists($key) ? $this->infos[$key] : null;
	}
	
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->infos);
	}
	
	public function offsetUnset($key)
	{
		throw new RunTimeException('Disabled');
	}
	
	public function getCountry()
	{
		return $this['country'];
	}
	
	public function getLoc()
	{
		$loc = $this['loc'];
		
		if (! $loc) {
			
			return null;
		}
		
		return array_map('floatval', explode(',', $loc));
	}
	
	public function getRegion()
	{
		return $this['region'];
	}
	
	public function getCity()
	{
		return $this['city'];
	}
	
	public function getIP()
	{
		return $this['ip'];
	}
	
	public function getPostal()
	{
		return $this['postal'];
	}
	
	public function getHostname()
	{
		return $this['hostname'];
	}
}

class IPInfo
{
	const URL = '%s://ipinfo.io/%s/%s';
	
	const IP = 'ip';
	
	const HOST = 'host';
	
	const CITY = 'city';
	
	protected $field = null;
	
	protected $ip;
	
	protected $secure = false;
	
	public function __construct($ip)
	{
		$this->ip = $ip;
	}
	
	public function setSecure($secure)
	{
		$this->secure = (bool) $secure;
	}
	
	public function getIP()
	{
		return $this->ip;
	}
	
	public function getResponse()
	{
		return new Response($this->getParsedResponse());
	}
	
	protected function getParsedResponse()
	{
		$curl = curl_init($this->buildUrl());

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec($curl);
		
		curl_close($curl);
		
		return (array) json_decode($response, true);
	}
	
	protected function buildUrl()
	{
		return sprintf(static::URL, $this->secure ? 'https' : 'http', $this->ip, $this->field);
	}
	
	public static function get($ip)
	{
		if (is_array($ip)) {
			
			return new Collection($ip);
		}
		
		return (new static($ip))->getResponse();
	}
}



$x = IPInfo::get(['8.8.8.8', '7.7.7.7']);
