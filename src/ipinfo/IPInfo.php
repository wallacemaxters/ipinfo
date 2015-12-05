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
    * @return \WallaceMaxters\IPInfo\Response
    */

    public function getResponse()
    {
        return new Response($this);
    }
    
    /**
     * Build the url for 
     * @return string
     * */

    public function buildUrl()
    {
        return sprintf(static::URL, $this->secure ? 'https' : 'http', $this->ip, $this->field);
    }
    
    /**
    * Returns a collection of responses or a response
    * @static
    * @param string $ip
    * @return \WallaceMaxters\IPInfo\Collection | \WallaceMaxters\IPInfo\Response
    */
    public static function get($ip)
    {
        if (is_array($ip)) {
            
            return new Collection($ip);
        }

        return (new static($ip))->getResponse();
    }


    /**
     * Returns a collection of response or a response by host passed
     * @param string $host
    * @return \WallaceMaxters\IPInfo\Collection | \WallaceMaxters\IPInfo\Response
     * */

    public static function getFromHost($host)
    {
        if (is_array($host)) {

            return new Collection(array_map('gethostbyname', $host));
        }

        return static::get(gethostname($host));
    }

}