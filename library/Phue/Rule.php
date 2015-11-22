<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\DeleteRule;

/**
 * Rule object
 */
class Rule
{
    /**
     * Status: Enabled
     */
    const STATUS_ENABLED = 'enabled';

    /**
     * Status: Disabled
     */
    const STATUS_DISABLED = 'disabled';

    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Rule attributes
     *
     * @var \stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Rule object
     *
     * @param string    $id         Id
     * @param \stdClass $attributes Rule attributes
     * @param Client    $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = $id;
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get rule Id
     *
     * @return int Rule id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of rule
     *
     * @return string Name of rule
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Get last triggered time
     *
     * @return string Time
     */
    public function getLastTriggeredTime()
    {
        return $this->attributes->lasttriggered;
    }

    /**
     * Get create date
     *
     * @return string Time
     */
    public function getCreateDate()
    {
        return $this->attributes->created;
    }

    /**
     * Get triggered count
     *
     * @return int Triggered count
     */
    public function getTriggeredCount()
    {
        return $this->attributes->timestriggered;
    }

    /**
     * Get owner
     *
     * @return string Owner
     */
    public function getOwner()
    {
        return $this->attributes->owner;
    }

    /**
     * Is enabled?
     *
     * @return bool True of enabled, false if not
     */
    public function isEnabled()
    {
        return $this->attributes->status == self::STATUS_ENABLED;
    }

    /**
     * Get conditions
     *
     * @return array List of conditions
     */
    public function getConditions()
    {
        $conditions = [];

        foreach ($this->attributes->conditions as $condition) {
            $conditions[] = new Condition($condition);
        }

        return $conditions;
    }

    /**
     * Get actions
     *
     * @return array List of actions
     */
    public function getActions()
    {
        $actions = [];

        foreach ($this->attributes->actions as $action) {
            $actions[] = $action;
        }

        return $actions;
    }

    /**
     * Delete rule
     */
    public function delete()
    {
        $this->client->sendCommand(
            (new DeleteRule($this))
        );
    }

    /**
     * __toString
     *
     * @return string Rule Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
