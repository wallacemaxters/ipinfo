<?php

namespace WallaceMaxters\IPInfo;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class IPInfo
{
	const URL = '%s://ipinfo.io/%s/%s';
	
	protected $ip;
	
	protected $secure = false;

	protected $field = 'json';
	
	public function __construct($ip)
	{
		$this->ip = $ip;
	}
	
	/**
	* @param boolean $secure
	* @return $this
	*/
	public function setSecure($secure)
	{
		$this->secure = (bool) $secure;

		return $this;
	}

	/**
	* Get defined IP
	* @return string
	*/
	public function getIP()
	{
		return $this->ip;
	}
	
	/**
	* Create response from curl request
	*/

	public function getResponse()
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
	
	/**
	* Return a collection of responses or a response
	* @return \WallaceMaxters\IPInfo\Collection or \WallaceMaxters\IPInfo\Response
	*/
	public static function get($ip, \Closure $callback = null)
	{
		if (is_array($ip)) {
			
			return new Collection($ip);
		}

		$instance = new static($ip);

		if ($callback instanceof \Closure) {

			$callback($instance);
		}
		
		return new Response($instance);
	}
}