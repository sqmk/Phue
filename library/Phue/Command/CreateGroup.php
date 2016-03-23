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
 * Create group command
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
    protected $lights = array();

    /**
     * Constructs a command
     *
     * @param string $name
     *            Name
     * @param array $lights
     *            List of light Ids or Light objects
     */
    public function __construct($name, array $lights = array())
    {
        $this->name($name);
        $this->lights($lights);
    }

    /**
     * Set name
     *
     * @param string $name
     *            Name
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
     * @param array $lights
     *            List of light Ids or Light objects
     *
     * @return self This object
     */
    public function lights(array $lights = array())
    {
        $this->lights = array();
        
        // Iterate through each light and append id to group list
        foreach ($lights as $light) {
            $this->lights[] = (string) $light;
        }
        
        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client
     *            Phue Client
     *
     * @return int Group Id
     */
    public function send(Client $client)
    {
        $response = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/groups",
            TransportInterface::METHOD_POST,
            (object) array(
                'name' => $this->name,
                'lights' => $this->lights
            )
        )
            ;
        
            $r = explode('/', $response->id);
            return $r[2];
    }
}
