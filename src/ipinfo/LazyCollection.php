<?php

namespace WallaceMaxters\IPInfo;

/**
* Collection of IPInfo
* This collection loads all ips without response call
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class LazyCollection extends Collection
{

	/**
	* @{inheritdoc}
	*/
	public function add(IPInfo $ip)
	{
		$this->items[$ip->getIP()] = $ip;

		return $this;
	}

	/**
	* Converts collection in array of IPInfo 
	*/

	public function toArray()
	{
		return iterator_to_array($this);
	}
}