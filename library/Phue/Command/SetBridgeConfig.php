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
     * Default proxy address
     */
    const DEFAULT_PROXY_ADDRESS = 'none';

    /**
     * Default proxy port
     */
    const DEFAULT_PROXY_PORT = 0;

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
            "/api/{$client->getUsername()}/config",
            TransportInterface::METHOD_PUT,
            (object) $this->config
        );
    }
}
