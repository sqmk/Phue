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
use Phue\Light;

/**
 * Get light by id command
 */
class GetLightById implements CommandInterface
{
    /**
     * Light Id
     *
     * @var string
     */
    protected $lightId;

    /**
     * Constructs a command
     *
     * @param int $lightId Light Id
     */
    public function __construct($lightId)
    {
        $this->lightId = (int) $lightId;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Light Light object
     */
    public function send(Client $client)
    {
        // Get response
        $attributes = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/lights/{$this->lightId}"
        );

        return new Light($this->lightId, $attributes, $client);
    }
}
