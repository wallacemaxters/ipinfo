<?php

namespace WallaceMaxters\IPInfo

use RunTimeException;
use ArrayAccess;
/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

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