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
 * Update rule command
 */
class UpdateRule extends CreateRule
{
    /**
     * Rule Id
     *
     * @var string
     */
    protected $ruleId;

    /**
     * Rule attributes
     *
     * @var array
     */
    protected $attributes = [];

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
     * Set name
     *
     * @param string $name Name
     *
     * @return self This object
     */
    public function name($name)
    {
        $this->attributes['name'] = (string) $name;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     */
    public function send(Client $client)
    {
        $attributes = $this->attributes;

        foreach ($this->conditions as $condition) {
            $attributes['conditions'][] = $condition->export();
        }

        foreach ($this->actions as $action) {
            $attributes['actions'][] = $action->getActionableParams($client);
        }

        $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/rules/{$this->ruleId}",
            TransportInterface::METHOD_PUT,
            (object) $attributes
        );
    }
}
