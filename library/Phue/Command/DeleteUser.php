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
 * Delete user command
 */
class DeleteUser implements CommandInterface
{
    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Constructs a command
     *
     * @param mixed $username Username or User object
     */
    public function __construct($username)
    {
        $this->username = (string) $username;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/config/whitelist/{$this->username}",
            TransportInterface::METHOD_DELETE
        );
    }
}
