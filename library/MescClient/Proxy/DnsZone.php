<?php

namespace MescClient\Proxy;

class DnsZone extends Zend\XmlRpc\Client\ServerProxy
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
	 * List all current DNS zones
	 */
	public function listZones()
	{
		return $this->_client->call(self::PROXY_NAMESPACE . '.listZones');
	}
}