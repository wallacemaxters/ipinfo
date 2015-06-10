<?php

namespace WallaceMaxters\IPInfo;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class IPInfo
{
	const URL = '%s://ipinfo.io/%s/json';
	
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
		return sprintf(static::URL, $this->secure ? 'https' : 'http', $this->ip);
	}
	
	/**
	* Return a collection of responses or a response
	* @return \WallaceMaxters\IPInfo\Collection or \WallaceMaxters\IPInfo\Response
	*/
	public static function get($ip)
	{
		if (is_array($ip)) {
			
			return new Collection($ip);
		}
		
		return (new static($ip))->getResponse();
	}
}