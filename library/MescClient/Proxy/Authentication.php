<?php

namespace MescClient\Proxy;

class Authentication extends Zend\XmlRpc\Client\ServerProxy
{
	/**
	 * Namespace of this proxy
	 * @var string
	 */
	const PROXY_NAMESPACE = 'dnszone';
	
	/**
	 * Class constructor
	 *
	 * @param \Zend\XmlRpc\Client $client
	 */
	public function __construct(XMLRPCClient $client)
	{
		parent::__construct($client, self::PROXY_NAMESPACE);
	}
	
	/**
	 * Validates an API token
	 * @param string $token
	 */
	public function validate($token)
	{
		return $this->_client->call(self::PROXY_NAMESPACE . '.validate', array($token), true);
	}
}