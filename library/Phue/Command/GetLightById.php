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
use Phue\Command\CommandInterface;
use Phue\Light;

/**
 * Get light by id command
 *
 * @category Phue
 * @package  Phue
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
     * @return Light Light objects
     */
    public function send(Client $client)
    {
        // Get response
        $details = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/lights/{$this->lightId}"
        );

        return new Light($this->lightId, $details, $client);
    }
}
