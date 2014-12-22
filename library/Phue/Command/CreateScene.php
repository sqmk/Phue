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
 * Create scene command
 */
class CreateScene implements CommandInterface
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
     * @param string $id     Id.
     * @param string $name   Name
     * @param array  $lights List of light Ids or Light objects
     */
    public function __construct($id, $name, array $lights = [])
    {
        $this->id($id);
        $this->name($name);
        $this->lights($lights);
    }

    /**
     * Set id
     *
     * @param string $id Custom scene id
     *
     * @return self This object
     */
    public function id($id)
    {
        $this->id = (string) $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return self This object
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
     * @return self This object
     */
    public function lights(array $lights = [])
    {
        $this->lights = [];

        // Iterate through each light and append id to scene list
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
     * @return int Scene Id
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/scenes/{$this->id}",
            TransportInterface::METHOD_PUT,
            (object) [
                'name'   => $this->name,
                'lights' => $this->lights
            ]
        );
    }
}
