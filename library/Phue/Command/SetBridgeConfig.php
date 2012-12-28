<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue\Command;

use Phue\Client;
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;

/**
 * Set bridge config command
 *
 * @category Phue
 * @package  Phue
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
     *
     * @return void
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
