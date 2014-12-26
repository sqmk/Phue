<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\CommandInterface;
use Phue\Command\GetBridge;
use Phue\Command\GetGroups;
use Phue\Command\GetLights;
use Phue\Command\GetRules;
use Phue\Command\GetScenes;
use Phue\Command\GetSchedules;
use Phue\Command\GetSensors;
use Phue\Command\GetTimezones;
use Phue\Command\GetUsers;
use Phue\Transport\Http;
use Phue\Transport\TransportInterface;

/**
 * Client for connecting to Philips Hue bridge
 */
class Client
{
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
     *
     * @param string $host Host
     *
     * @return self This object
     */
    public function setHost($host)
    {
        $this->host = (string) $host;

        return $this;
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
     *
     * @return self This object
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;

        return $this;
    }

    /**
     * Get bridge
     *
     * @return Bridge Bridge object
     */
    public function getBridge()
    {
        return $this->sendCommand(
            new GetBridge
        );
    }

    /**
     * Get users
     *
     * @return User[] List of User objects
     */
    public function getUsers()
    {
        return $this->sendCommand(
            new GetUsers
        );
    }

    /**
     * Get lights
     *
     * @return Light[] List of Light objects
     */
    public function getLights()
    {
        return $this->sendCommand(
            new GetLights
        );
    }

    /**
     * Get groups
     *
     * @return Group[] List of Group objects
     */
    public function getGroups()
    {
        return $this->sendCommand(
            new GetGroups
        );
    }

    /**
     * Get schedules
     *
     * @return Schedule[] List of Schedule objects
     */
    public function getSchedules()
    {
        return $this->sendCommand(
            new GetSchedules
        );
    }

    /**
     * Get scenes
     *
     * @return Scene[] List of Scene objects
     */
    public function getScenes()
    {
        return $this->sendCommand(
            new GetScenes
        );
    }

    /**
     * Get sensors
     *
     * @return Sensor[] List of Sensor objects
     */
    public function getSensors()
    {
        return $this->sendCommand(
            new GetSensors
        );
    }

    /**
     * Get rules
     *
     * @return Rule[] List of Rule objects
     */
    public function getRules()
    {
        return $this->sendCommand(
            new GetRules
        );
    }

    /**
     * Get timezones
     *
     * @return array List of timezones
     */
    public function getTimezones()
    {
        return $this->sendCommand(
            new GetTimezones
        );
    }

    /**
     * Get transport
     *
     * @return TransportInterface Transport
     */
    public function getTransport()
    {
        // Set transport if haven't
        if ($this->transport === null) {
            $this->setTransport(new Http($this));
        }

        return $this->transport;
    }

    /**
     * Set transport
     *
     * @param TransportInterface $transport Transport
     *
     * @return self This object
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Send command to server
     *
     * @param CommandInterface $command Phue command
     *
     * @return mixed Command result
     */
    public function sendCommand(CommandInterface $command)
    {
        return $command->send($this);
    }
}
