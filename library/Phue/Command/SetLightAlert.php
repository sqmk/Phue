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
 * Set light alert command
 *
 * @category Phue
 * @package  Phue
 */
class SetLightAlert implements CommandInterface
{
    /**
     * Long select mode
     */
    const MODE_LONG_SELECT = 'lselect';

    /**
     * Select mode
     */
    const MODE_SELECT = 'select';

    /**
     * Light
     *
     * @var Light
     */
    protected $light;

    /**
     * Alert mode
     * 
     * @var string
     */
    protected $mode;

    /**
     * Constructor
     *
     * @param Light $light Light
     * @param string $mode
     */
    public function __construct(Light $light, $mode)
    {
        // Don't continue if mode is not valid
        if (!in_array($mode, self::getModes())) {
            throw new \InvalidArgumentException(
                "{$mode} is not a valid alert mode"
            );    
        }

        $this->light = $light;
        $this->mode  = $mode;
    }

    /**
     * Get modes
     *
     * @return array List of modes
     */
    public static function getModes()
    {
        return [
            self::MODE_SELECT,
            self::MODE_LONG_SELECT,
        ];
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
            "{$client->getUsername()}/lights/{$this->light->getId()}/state",
            Http::METHOD_PUT,
            (object) [
                'alert' => 'lselect'
            ]
        );
    }
}
