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
class SetLightState implements CommandInterface
{
    /**
     * Alert select mode
     */
    const ALERT_SELECT = 'select';

    /**
     * Alert long select mode
     */
    const ALERT_LONG_SELECT = 'lselect';

    /**
     * Light Id
     *
     * @var string
     */
    protected $lightId;

    /**
     * State parameters
     *
     * @var array
     */
    protected $params = [];

    /**
     * Get modes
     *
     * @return array List of modes
     */
    public static function getAlertModes()
    {
        return [
            self::ALERT_SELECT,
            self::ALERT_LONG_SELECT,
        ];
    }

    /**
     * Constructs a command
     *
     * @param mixed $light Light Id or Light object
     */
    public function __construct($light)
    {
        $this->lightId = (string) $light;
    }

    /**
     * Set on parameter
     *
     * @param bool $flag True if on, false if not
     *
     * @return SetLightState self object
     */
    public function on($flag = true)
    {
        $this->params['on'] = (bool) $flag;

        return $this;
    }

    /**
     * Set alert parameter
     *
     * @param string $mode Alert mode
     *
     * @return SetLightState self object
     */
    public function alert($mode)
    {
        // Don't continue if mode is not valid
        if (!in_array($mode, self::getAlertModes())) {
            throw new \InvalidArgumentException(
                "{$mode} is not a valid alert mode"
            );
        }

        $this->params['alert'] = $mode;

        return $this;
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
            "{$client->getUsername()}/lights/{$this->lightId}/state",
            Http::METHOD_PUT,
            (object) $this->params
        );
    }
}
