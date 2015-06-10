<?php

namespace WallaceMaxters\IPInfo;

use IteratorAggregate;
use ArrayIterator;

/**
* Collection of \WallaceMaxters\IPInfo\Response
*/
class Collection implements IteratorAggregate
{
	protected $items = [];
	
	public function __construct(array $ips)
	{
		foreach ($ips as $ip) {
			
			if ($ip instanceof IPInfo) {
				
				$this->add($ip);
				
				continue;
			}
			
			$this->items[$ip] = (new IPInfo($ip))->getResponse();
		}
	}
	
	public function add(IPInfo $ip)
	{
		$this->items[$ip->getIP()] = $ip->getResponse();
		
		return $this;
	}
	
	public function addFromIP($ip)
	{
		return $this->add(new IPInfo($ip));
	}
	
	public function delete($ip)
	{
		unset($this->items[$ip]);
		
		return $this;
	}
	
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
	
}