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
     * @param Client    $client     Phue client
     */
    public function __construct(\stdClass $attributes, Client $client)
    {
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get name
     *
     * @return string Bridge name
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
     * @return self This object
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
     * Get ZigBee channel
     *
     * @return int ZygBee Channel
     */
    public function getZigBeeChannel()
    {
        return $this->attributes->zigbeechannel;
    }

    /**
     * Set ZigBee channel
     *
     * @param int $channel Channel
     *
     * @return self This object
     */
    public function setZigBeeChannel($channel)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['zigbeechannel' => (int) $channel]
            )
        );

        $this->attributes->zigbeechannel = (int) $channel;

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
     * Enable DHCP
     *
     * @param bool $state True to enable, false to disable
     *
     * @return self This object
     */
    public function enableDhcp($state = true)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['dhcp' => (bool) $state]
            )
        );

        $this->attributes->dhcp = (bool) $state;

        return $this;
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
     * Set IP Address
     *
     * @param string $ipAddress IP Address
     *
     * @return self This object
     */
    public function setIpAddress($ipAddress)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['ipaddress' => (string) $ipAddress]
            )
        );

        $this->attributes->ipaddress = (string) $ipAddress;

        return $this;
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
     * Set Netmask
     *
     * @param string $netmask Netmask
     *
     * @return self This object
     */
    public function setNetmask($netmask)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['netmask' => (string) $netmask]
            )
        );

        $this->attributes->netmask = (string) $netmask;

        return $this;
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
     * Set Gateway
     *
     * @param string $gateway Gateway
     *
     * @return self This object
     */
    public function setGateway($gateway)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['gateway' => (string) $gateway]
            )
        );

        $this->attributes->gateway = (string) $gateway;

        return $this;
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
     * Set Proxy address
     *
     * @param string $proxyAddress Proxy address
     *
     * @return self This object
     */
    public function setProxyAddress($proxyAddress = SetBridgeConfig::DEFAULT_PROXY_ADDRESS)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['proxyaddress' => (string) $proxyAddress]
            )
        );

        $this->attributes->proxyaddress = (string) $proxyAddress;

        return $this;
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
     * Set Proxy port
     *
     * @param int $proxyAddress Proxy port
     *
     * @return self This object
     */
    public function setProxyPort($proxyPort = SetBridgeConfig::DEFAULT_PROXY_PORT)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['proxyport' => (int) $proxyPort]
            )
        );

        $this->attributes->proxyport = (int) $proxyPort;

        return $this;
    }

    /**
     * Get UTC time of bridge
     *
     * @return string Date
     */
    public function getUtcTime()
    {
        return $this->attributes->UTC;
    }

    /**
     * Get local time of bridge
     *
     * @return string Date
     */
    public function getLocalTime()
    {
        return $this->attributes->localtime;
    }

    /**
     * Get timezone
     *
     * @return string Date
     */
    public function getTimezone()
    {
        return $this->attributes->timezone;
    }

    /**
     * Set timezone
     *
     * @param string $timezone Timezone
     *
     * @return self This object
     */
    public function setTimezone($timezone)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['timezone' => (string) $timezone]
            )
        );

        $this->attributes->timezone = (string) $timezone;

        return $this;
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
     * Get API version
     *
     * @return string API Version
     */
    public function getApiVersion()
    {
        return $this->attributes->apiversion;
    }

    /**
     * Get software update
     *
     * @return SoftwareUpdate SoftwareUpdate object
     */
    public function getSoftwareUpdate()
    {
        return new SoftwareUpdate($this->attributes->swupdate, $this->client);
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
     * Set link button state
     *
     * @param bool $state True for on, false for off
     *
     * @return self This object
     */
    public function setLinkButtonOn($state = true)
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                ['linkbutton' => (bool) $state]
            )
        );

        $this->attributes->linkbutton = (bool) $state;

        return $this;
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

    /**
     * Is portal connected?
     *
     * @return bool True if portal is connected, false if not
     */
    public function isPortalConnected()
    {
        return $this->attributes->portalconnection == 'connected';
    }

    /**
     * Get portal
     *
     * @return Portal Portal object
     */
    public function getPortal()
    {
        return new Portal($this->attributes->portalstate, $this->client);
    }
}
