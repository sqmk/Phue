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
 * Delete rule command
 */
class DeleteRule implements CommandInterface
{
    /**
     * Rule Id
     *
     * @var string
     */
    protected $ruleId;

    /**
     * Constructs a command
     *
     * @param mixed $rule Rule Id or Rule object
     */
    public function __construct($rule)
    {
        $this->ruleId = (string) $rule;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/rules/{$this->ruleId}",
            TransportInterface::METHOD_DELETE
        );
    }
}
