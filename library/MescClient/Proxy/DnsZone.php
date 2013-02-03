<?php

namespace MescClient\Proxy;

use MescClient\Client;
use Zend\XmlRpc\Client\ServerProxy;

class DnsZone extends ServerProxy
{
    /**
     * @var Client
     */
    private $client = null;
    
	/**
	 * Namespace of this proxy
	 * @var string
	 */
	const PROXY_NAMESPACE = 'dnszone';
	
	/**
	 * Class constructor
	 *
	 * @param Client $client
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
		parent::__construct($client, self::PROXY_NAMESPACE);
	}
	
	/**
	 * List all current DNS zones
	 */
	public function listAll()
	{
		return $this->client->call(self::PROXY_NAMESPACE . '.listAll');
	}
}