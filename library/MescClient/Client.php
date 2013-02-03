<?php

use MescClient\Proxy\DnsZone;
namespace MescClient;

use MescClient\Proxy\Authentication;

use Zend\Http\Client as HttpClient;
use Zend\XmlRpc\Client as XmlRpcClient;
use MescClient\Proxy;

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
    	if (!$noToken) {
	    	// add token as first parameter
	        $params = array_unshift($params, $this->getToken());
    	}
        
        parent::call($method, $params);
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