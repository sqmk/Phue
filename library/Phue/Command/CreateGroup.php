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
 * Create group command
 *
 * @category Phue
 * @package  Phue
 */
class CreateGroup implements CommandInterface
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Lights
     *
     * @var array List of light Ids
     */
    protected $lights = [];

    /**
     * Constructs a command
     *
     * @param string $name Name
     * @param array $lights List of light Ids or Light objects
     */
    public function __construct($name, array $lights = [])
    {
        $this->name($name);
        $this->lights($lights);
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return CreateGroup Self object
     */
    public function name($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Set lights
     *
     * @param array $lights List of light Ids or Light objects
     *
     * @return CreateGroup Self object
     */
    public function lights(array $lights = [])
    {
        $this->lights = [];

        // Iterate through each light and append id to group list
        foreach ($lights as $light) {
            $this->lights[] = (string) $light;
        }

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Group Id
     */
    public function send(Client $client)
    {
        $response = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/groups",
            TransportInterface::METHOD_POST,
            (object) [
                'name'   => $this->name,
                'lights' => $this->lights
            ]
        );

        return explode('/', $response->id)[2];
    }
}
