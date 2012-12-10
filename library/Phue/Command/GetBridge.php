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
use Phue\Bridge;

/**
 * Get bridge command
 *
 * @category Phue
 * @package  Phue
 */
class GetBridge implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Bridge Bridge object
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/config"
        );

        return new Bridge($response, $client);
    }
}
