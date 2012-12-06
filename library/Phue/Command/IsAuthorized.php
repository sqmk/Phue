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
use Phue\Transport\Http;
use Phue\Command\CommandInterface;

/**
 * Authenticate command
 *
 * @category Phue
 * @package  Phue
 */
class IsAuthorized implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return bool True if authorized, false if not
     */
    public function send(Client $client)
    {
        // Get response
        try {
            $client->getTransport()->sendRequest(
                $client->getUsername()
            );
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }
}
