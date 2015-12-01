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


	/**
	 * @param array $ips
	 * */
	
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
	
	/**
	 * @param IPInfo $ip
	 * @return \WallaceMaxters\IPInfo\Collection
	 * */
	public function add(IPInfo $ip)
	{
		$this->items[$ip->getIP()] = $ip->getResponse();
		
		return $this;
	}
	
	/**
	 * Create IPInfo object from string and add in collection
	 * @param string $ip 
	 * @return \WallaceMaxters\IPInfo\Collection	 * 
	 * */
	public function addFromIP($ip)
	{
		return $this->add(new IPInfo($ip));
	}
	
	/**
	 * Remove IP from collection
	 * @param string $ip
	 *@return \WallaceMaxters\IPInfo\Collection
	 * */
	public function delete($ip)
	{
		unset($this->items[$ip]);
		
		return $this;
	}
	
	/**
	 * Implementaion for iteratorAggregate
	 * @return \ArrayIterator
	 * */
	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
	
}