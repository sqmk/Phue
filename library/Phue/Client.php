<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Transport\Http;
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;
use Phue\Command\GetBridge;
use Phue\Command\GetLights;
use Phue\Command\GetGroups;
use Phue\Command\GetSchedules;

/**
 * Client for connecting to Philips Hue bridge
 */
class Client
{
    /**
     * Client name
     */
    const DEFAULT_DEVICE_TYPE = 'Phue';

    /**
     * Host address
     *
     * @var string
     */
    protected $host = null;

    /**
     * Username
     *
     * @var string
     */
    protected $username = null;

    /**
     * Transport
     *
     * @var TransportInterface
     */
    protected $transport = null;

    /**
     * Construct a Phue Client
     *
     * @param string $host     Host address
     * @param string $username Username
     */
    public function __construct($host, $username = null)
    {
        $this->setHost($host);
        $this->setUsername($username);
    }

    /**
     * Get host
     *
     * @return string Host address
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set host
     */
    public function setHost($host)
    {
        $this->host = (string) $host;
    }

    /**
     * Get username
     *
     * @return string Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username Username
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
    }

    /**
     * Get bridge
     *
     * @return Bridge Bridge object
     */
    public function getBridge()
    {
        return $this->sendCommand(
            new GetBridge()
        );
    }

    /**
     * Get lights
     *
     * @return array List of Light objects
     */
    public function getLights()
    {
        return $this->sendCommand(
            new GetLights()
        );
    }

    /**
     * Get groups
     *
     * @return array List of Group objects
     */
    public function getGroups()
    {
        return $this->sendCommand(
            new GetGroups()
        );
    }

    /**
     * Get schedules
     *
     * @return array List of Schedule objects
     */
    public function getSchedules()
    {
        return $this->sendCommand(
            new GetSchedules()
        );
    }

    /**
     * Get transport
     *
     * @return TransportInterface
     */
    public function getTransport()
    {
        // Set transport if haven't
        if ($this->transport === null) {
            $this->transport = new Http($this);
        }

        return $this->transport;
    }

    /**
     * Set transport
     *
     * @param TransportInterface $transport Transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Send command to server
     *
     * @param Command $command Phue command
     */
    public function sendCommand(CommandInterface $command)
    {
        // Send command
        return $command->send($this);
    }
}
