<?php

namespace WallaceMaxters\IPInfo;

use RunTimeException;
use ArrayAccess;
use JsonSerializable;
/**
* @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
*/

class Response implements ArrayAccess, JsonSerializable
{


    /**
    * @var ipinfo
    */
    protected $ipinfo;

    /**
    * @var array
    */
    protected $infos = [];

    /**
    * @param \WallaceMaxters|IPInfo\Ipinfo $ipinfo
    * @uses \WallaceMaxters|IPInfo\Ipinfo::getResponse()
    */
    public function __construct(IPInfo $ipinfo)
    {
        $this->ipinfo = $ipinfo;

        $this->retrieveData();
    }
    
    /**
    * Disabled method
    * Implementation for \ArrayAccess
    * @throws \RunTimeException
    */
    public function offsetSet($key, $value)
    {
        throw new RunTimeException(sprintf('Method [%s] is disabled', __METHOD__));
    }
    
    public function offsetGet($key)
    {
        return $this->offsetExists($key) ? $this->infos[$key] : null;
    }
    
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->infos);
    }

    /**
    * Disabled method
    * Implementario for \ArrayAccess
    * @throws \RunTimeException
    */  
    public function offsetUnset($key)
    {
        throw new RunTimeException(sprintf('Method [%s] is disabled', __METHOD__));
    }
    
    /**
    * @return string|null
    */
    public function getCountry()
    {
        return $this['country'];
    }

    /**
    * @return array|null
    */
    
    public function getLoc()
    {
        $loc = $this['loc'];
        
        if (! $loc) {
            
            return null;
        }
        
        return array_map('floatval', explode(',', $loc));
    }
    
    /**
    * Get Region
    * @return string
    */
    public function getRegion()
    {
        return $this['region'];
    }

    /**
    * Get City
    * @return string
    */
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

    public function getOrg()
    {
        return $this['org'];
    }

    /**
    * Implementation for \JsonSerializable
    * @return array
    */
    public function jsonSerialize()
    {
        return $this->infos;
    }

    /**
    * Encodes the infos in JSON
    * @return string
    */
    public function toJson()
    {
        return json_encode($this);
    }

    /**
    * Easy way to retrieve json encode of infos
    * @return 
    */
    public function __toString()
    {
        return $this->toJson();
    }

    public function toArray()
    {
        return $this->infos + ['location' => $this->getLoc()];
    }

    protected function retrieveData()
    {
        $curl = \curl_init($this->ipinfo->buildUrl());

        \curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        
        $response = \curl_exec($curl);
        
        \curl_close($curl);
        
        $this->infos = \json_decode($response, true);

        return $this;
    }

}