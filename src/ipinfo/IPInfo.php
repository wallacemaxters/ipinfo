<?php

namespace WallaceMaxters\IPInfo;

/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/
class IPInfo
{
	const URL = '%s://ipinfo.io/%s/%s';
	
	/**
	 * @var string
	 **/
	protected $ip;
	
	/**
	 * Determine if request is ssl or https
	 * @var boolean
	 * */
	protected $secure = false;

	/**
	 * @var string
	 * */
	protected $field = 'json';
	
	/**
	 * @param string ip
	 * */
	public function __construct($ip)
	{
		$this->ip = $ip;
	}
	
	/**
	* @param boolean $secure
	* @return \WallaceMaxters\IPInfo\IPInfo
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
	* @return array
	*/

	public function getResponse()
	{
			
		$curl = curl_init($this->buildUrl());

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
		$response = curl_exec($curl);
	
		curl_close($curl);
		
		return (array) json_decode($response, true);
	}
	
	/**
	 * Build the url for 
	 * @access protected 
	 * @return string
	 * */

	protected function buildUrl()
	{
		return sprintf(static::URL, $this->secure ? 'https' : 'http', $this->ip, $this->field);
	}
	
	/**
	* Return a collection of responses or a response
	* @static
	* @param string $ip
	* @return \WallaceMaxters\IPInfo\Collection or \WallaceMaxters\IPInfo\Response
	*/
	public static function get($ip)
	{
		if (is_array($ip)) {
			
			return new Collection($ip);
		}

		return new Response($instance);
	}

}