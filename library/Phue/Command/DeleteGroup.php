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
 * Delete group command
 *
 * @category Phue
 * @package  Phue
 */
class DeleteGroup implements CommandInterface
{
    /**
     * Group Id
     * 
     * @var string
     */
    protected $groupId;

    /**
     * Constructs a command
     *
     * @param mixed $group Group Id or Group object
     */
    public function __construct($group)
    {
        $this->groupId = (string) $group;
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
            "{$client->getUsername()}/groups/{$this->groupId}",
            Http::METHOD_DELETE
        );
    }
}
