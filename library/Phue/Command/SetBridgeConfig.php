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
 * Set bridge config command
 */
class SetBridgeConfig implements CommandInterface
{
    /**
     * Config
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructs a command
     *
     * @param array $config Key/value pair config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "{$client->getUsername()}/config",
            TransportInterface::METHOD_PUT,
            (object) $this->config
        );
    }
}
