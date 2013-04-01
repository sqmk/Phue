<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\DeleteUser;

/**
 * User object
 */
class User
{
    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Details
     *
     * @var \stdClass
     */
    protected $details;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a User object
     *
     * @param string    $username Username
     * @param \stdClass $details  User details
     * @param Client    $client   Phue client
     */
    public function __construct($username, \stdClass $details, Client $client)
    {
        $this->username = (string) $username;
        $this->details  = $details;
        $this->client   = $client;
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
     * Get device type
     *
     * @return string Device type
     */
    public function getDeviceType()
    {
        return $this->details->name;
    }

    /**
     * Get create date
     *
     * @return string Create date
     */
    public function getCreateDate()
    {
        return $this->details->{'create date'};
    }

    /**
     * Get last use date
     *
     * @return string Last use date
     */
    public function getLastUseDate()
    {
        return $this->details->{'last use date'};
    }

    /**
     * Delete user
     */
    public function delete()
    {
        $this->client->sendCommand(
            (new DeleteUser($this))
        );
    }

    /**
     * __toString
     *
     * @return string Username
     */
    public function __toString()
    {
        return (string) $this->username;
    }
}
