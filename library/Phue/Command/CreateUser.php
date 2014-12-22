<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Command;

use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Create user command
 */
class CreateUser implements CommandInterface
{
    /**
     * Username to create
     *
     * @var string
     */
    protected $username;

    /**
     * Device type
     *
     * @var string
     */
    protected $deviceType;

    /**
     * Instantiates a create user command
     *
     * @param string $username   Username
     * @param string $deviceType Device type
     */
    public function __construct($username = null, $deviceType = Client::DEFAULT_DEVICE_TYPE)
    {
        $this->setUsername($username);
        $this->setDeviceType($deviceType);
    }

    /**
     * Set username
     *
     * @param string $username Username
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function setUsername($username)
    {
        // Allow for null username
        if ($username === null) {
            return;
        }

        // Match username format
        if (!preg_match('/^[a-z0-9]{10,40}$/i', $username)) {
            throw new \InvalidArgumentException(
                "Username must contain alphanumeric characters, and be between 10 and 40 characters"
            );
        }

        $this->username = $username;
    }

    /**
     * Set device type
     *
     * @param string $deviceType Device type
     *
     * @throws \InvalidArgumentException
     *
     * @return self This object
     */
    public function setDeviceType($deviceType)
    {
        if (strlen($deviceType) > 40) {
            throw new \InvalidArgumentException(
                "Device type must not have a length have more than 40 characters"
            );
        }

        $this->deviceType = (string) $deviceType;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return \stdClass Authentication response
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            '/api',
            TransportInterface::METHOD_POST,
            $this->buildRequestData($client)
        );

        return $response;
    }

    /**
     * Build request data
     *
     * @param Client $client Phue client
     *
     * @return \stdClass Request data object
     */
    protected function buildRequestData(Client $client)
    {
        // Initialize data to send
        $request = [
            'devicetype' => $this->deviceType
        ];

        // Leave username blank if one not provided
        if ($this->username !== null) {
            $request['username'] = (string) $this->username;
        }

        return (object) $request;
    }
}
