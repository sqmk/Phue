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
use Phue\Condition;
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
    public function __construct($name = '')
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
     * @param Condition $condition Condition
     *
     * @return self This object
     */
    public function addCondition(Condition $condition)
    {
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
        $response = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/rules",
            TransportInterface::METHOD_POST,
            (object) [
                'name'       => $this->name,
                'conditions' => array_map(
                    function ($condition) {
                        return $condition->export();
                    },
                    $this->conditions
                ),
                'actions'    => array_map(
                    function ($action) use ($client) {
                        return $action->getActionableParams($client);
                    },
                    $this->actions
                ),
            ]
        );

        return $response->id;
    }
}
