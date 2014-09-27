<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\SetBridgeConfig;

/**
 * Bridge object
 */
class Bridge
{
    /**
     * Bridge attributes
     *
     * @var \stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

	/**
	 * Construct a Phue Bridge object
	 *
	 * @param \stdClass $attributes Bridge attributes
	 * @param Client $client
	 */
	public function __construct(\stdClass $attributes, Client $client)
    {
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Set name of bridge
     *
     * @param string $name Name
     *
     * @return Bridge Self object
     */
    public function setName($name)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['name' => (string) $name]
            )
        );

        $this->attributes->name = (string) $name;

        return $this;
    }

    /**
     * Get MAC address of bridge
     *
     * @return string MAC address
     */
    public function getMacAddress()
    {
        return $this->attributes->mac;
    }

    /**
     * Is DHCP enabled?
     *
     * @return bool True if DHCP is enabled, false if not
     */
    public function isDhcpEnabled()
    {
        return (bool) $this->attributes->dhcp;
    }

    /**
     * Get IP Address
     *
     * @return string IP address
     */
    public function getIpAddress()
    {
        return $this->attributes->ipaddress;
    }

    /**
     * Get netmask
     *
     * @return string Netmask
     */
    public function getNetmask()
    {
        return $this->attributes->netmask;
    }

    /**
     * Get gateway address
     *
     * @return string Gateway address
     */
    public function getGateway()
    {
        return $this->attributes->gateway;
    }

    /**
     * Get proxy address
     *
     * @return string Proxy address
     */
    public function getProxyAddress()
    {
        return $this->attributes->proxyaddress;
    }

    /**
     * Get proxy port
     *
     * @return string Proxy port
     */
    public function getProxyPort()
    {
        return $this->attributes->proxyport;
    }

    /**
     * Get local UTC date of bridge
     *
     * @return string Date
     */
    public function getUtcDate()
    {
        return $this->attributes->UTC;
    }

    /**
     * Get software version
     *
     * @return string Software version
     */
    public function getSoftwareVersion()
    {
        return $this->attributes->swversion;
    }

    /**
     * Is the link button on?
     *
     * @return bool True if the link button on, false if not
     */
    public function isLinkButtonOn()
    {
        return (bool) $this->attributes->linkbutton;
    }

    /**
     * Are portal services enabled?
     *
     * @return bool True if services are on, false if not
     */
    public function arePortalServicesEnabled()
    {
        return (bool) $this->attributes->portalservices;
    }
}
