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
 * Create rule command
 */
class CreateRule implements CommandInterface
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Conditions
     *
     * @var array
     */
    protected $conditions = [];

    /**
     * Actions
     *
     * @var array
     */
    protected $actions = [];

    /**
     * Constructs a command
     *
     * @param string $name Name
     */
    public function __construct($name)
    {
        $this->name($name);
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
     * Add condition
     *
     * @param string $sensorId  Sensor Id
     * @param string $attribute Attribute
     * @param string $operator  Operator
     * @param string $value     Value
     *
     * @return self This object
     */
    public function addCondition($sensorId, $attribute, $operator, $value = null)
    {
        $condition = [
            'address'  => "/sensors/{$sensorId}/state/{$attribute}",
            'operator' => (string) $operator,
        ];

        if ($value !== null) {
            $condition['value'] = (string) $value;
        }

        $this->conditions[] = $condition;

        return $this;
    }

    /**
     * Add actionable command
     *
     * @param ActionableInterface $action Actionable command
     *
     * @return self This object
     */
    public function addAction(ActionableInterface $command)
    {
        $this->actions[] = $command;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Rule Id
     */
    public function send(Client $client)
    {
        $actions = [];
        foreach ($this->actions as $action) {
            $actions[] = $action->getActionableParams($client);
        }

        $response = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/rules",
            TransportInterface::METHOD_POST,
            (object) [
                'name'       => $this->name,
                'conditions' => $this->conditions,
                'actions'    => $actions,
            ]
        );

        return $response->id;
    }
}
