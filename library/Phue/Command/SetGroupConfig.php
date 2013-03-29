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
 * Set group config command
 */
class SetGroupConfig implements CommandInterface
{
    /**
     * Group Id
     *
     * @var string
     */
    protected $groupId;

    /**
     * Config parameters
     *
     * @var array
     */
    protected $params = [];

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
     * Set name
     *
     * @param string $name Name
     *
     * @return Group Self object
     */
    public function name($name)
    {
        $this->params['name'] = (string) $name;

        return $this;
    }

    /**
     * Set lights
     *
     * @param array $lights List of light Ids or Light objects
     *
     * @return Group Self object
     */
    public function lights(array $lights)
    {
        $lightList = [];

        foreach ($lights as $light) {
            $lightList[] = (string) $light;
        }

        $this->params['lights'] = $lightList;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "{$client->getUsername()}/groups/{$this->groupId}",
            TransportInterface::METHOD_PUT,
            (object) $this->params
        );
    }
}
