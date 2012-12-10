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

/**
 * Ping command
 *
 * @category Phue
 * @package  Phue
 */
class Ping implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return void
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest('none/config');
    }
}
