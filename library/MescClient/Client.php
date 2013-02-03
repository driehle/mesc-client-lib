<?php

namespace MescClient;

use Zend\Http\Client as HttpClient;
use Zend\XmlRpc\Client as XmlRpcClient;
use MescClient\Proxy\Authentication;
use MescClient\Proxy\DnsZone;

class Client extends XmlRpcClient
{
	/**
	 * Authentication token
	 * @var string
	 */
	protected $_token;
	
	/**
	 * Cache for service proxies
	 * @var Zend\XmlRpc\Client\ServerProxy[]
	 */
	protected $_serviceProxies;
	
	/**
	 * Set the authentication token
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->_token = (string) $token;
		return $this;
	}
	
	/**
	 * Get the authentication token
	 * @return string|null
	 */
	public function getToken()
	{
		return $this->_token;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Zend\XmlRpc.Client::call()
	 */
    public function call ($method, $params = array(), $noToken = false)
    {
    	if (!$noToken && substr($method, 0, 7) != 'system.') {
	    	// add token as first parameter
	        array_unshift($params, $this->getToken());
    	}
        
        return parent::call($method, $params);
    }
    
    /**
     * Get the proxy for authentication
     * @return Authentication
     */
    public function getAuthenticationProxy()
    {
    	if (!isset($this->_serviceProxies[Authentication::PROXY_NAMESPACE])) {
    		$this->_serviceProxies[Authentication::PROXY_NAMESPACE]
    			= new Authentication($this);
    	}
    	
    	return $this->_serviceProxies[Authentication::PROXY_NAMESPACE];
    }
    
    /**
     * Get the proxy for DNS zones
     * @return DnsZone
     */
    public function getDnsZoneProxy()
    {
    	if (!isset($this->_serviceProxies[DnsZone::PROXY_NAMESPACE])) {
    		$this->_serviceProxies[DnsZone::PROXY_NAMESPACE]
    			= new DnsZone($this);
    	}
    	
    	return $this->_serviceProxies[DnsZone::PROXY_NAMESPACE];
    }
}