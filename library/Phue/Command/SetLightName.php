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
use Phue\Light;
use Phue\Transport\Http;
use Phue\Command\CommandInterface;

/**
 * Set light name command
 *
 * @category Phue
 * @package  Phue
 */
class SetLightName implements CommandInterface
{
    /**
     * Light
     *
     * @var Light
     */
    protected $light;

    /**
     * New name
     *
     * @var string
     */
    protected $name;

    /**
     * Constructs a command
     *
     * @param Light $light Light
     * @param string $name Name of light
     */
    public function __construct(Light $light, $name)
    {
        $this->light = $light;
        $this->name  = (string) $name;
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
            "{$client->getUsername()}/lights/{$this->light->getId()}",
            Http::METHOD_PUT,
            (object) [
                'name' => $this->name
            ]
        );
    }
}
