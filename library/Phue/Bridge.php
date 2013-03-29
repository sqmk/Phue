<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
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
     * Bridge details
     *
     * @var stdClass
     */
    protected $details;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Bridge object
     *
     * @param stdClass $details Bridge details
     */
    public function __construct(\stdClass $details, Client $client)
    {
        $this->details = $details;
        $this->client  = $client;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->details->name;
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

        $this->details->name = (string) $name;

        return $this;
    }

    /**
     * Get MAC address of bridge
     *
     * @return string MAC address
     */
    public function getMacAddress()
    {
        return $this->details->mac;
    }

    /**
     * Is DHCP enabled?
     *
     * @return bool True if DHCP is enabled, false if not
     */
    public function isDhcpEnabled()
    {
        return (bool) $this->details->dhcp;
    }

    /**
     * Get IP Address
     *
     * @return string IP address
     */
    public function getIpAddress()
    {
        return $this->details->ipaddress;
    }

    /**
     * Get netmask
     *
     * @return string Netmask
     */
    public function getNetmask()
    {
        return $this->details->netmask;
    }

    /**
     * Get gateway address
     *
     * @return string Gateway address
     */
    public function getGateway()
    {
        return $this->details->gateway;
    }

    /**
     * Get proxy address
     *
     * @return string Proxy address
     */
    public function getProxyAddress()
    {
        return $this->details->proxyaddress;
    }

    /**
     * Get proxy port
     *
     * @return string Proxy port
     */
    public function getProxyPort()
    {
        return $this->details->proxyport;
    }

    /**
     * Get local UTC date of bridge
     *
     * @return string Date
     */
    public function getUtcDate()
    {
        return $this->details->UTC;
    }

    /**
     * Get software version
     *
     * @return string Software version
     */
    public function getSoftwareVersion()
    {
        return $this->details->swversion;
    }

    /**
     * Get whitelisted users
     *
     * @return array List of whitelisted users
     */
    public function getWhitelist()
    {
        $whitelist = [];

        // Iterate through each whitelist record and add to list
        foreach ($this->details->whitelist as $username => $record) {
            $whitelist[$username] = [
                'name'          => $record->name,
                'create_date'   => $record->{'create date'},
                'last_use_date' => $record->{'last use date'},
            ];
        }

        return $whitelist;
    }

    /**
     * Is the link button on?
     *
     * @return bool True if the link button on, false if not
     */
    public function isLinkButtonOn()
    {
        return (bool) $this->details->linkbutton;
    }

    /**
     * Are portal services enabled?
     *
     * @return bool True if services are on, false if not
     */
    public function arePortalServicesEnabled()
    {
        return (bool) $this->details->portalservices;
    }
}
