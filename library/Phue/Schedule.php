<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\SetScheduleAttributes;
use Phue\Command\SchedulableInterface;

/**
 * Schedule object
 */
class Schedule
{
    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Schedule attributes
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
     * Construct a Phue Schedule object
     *
     * @param int      $id         Id
     * @param \stdClass $attributes Schedule attributes
     * @param Client   $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = (int) $id;
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get schedule Id
     *
     * @return int Schedule id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of Schedule
     *
     * @return string Name of Schedule
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Set name of schedule
     *
     * @param string $name
     * @return Schedule Self object
     */
    public function setName($name)
    {
        $this->client->sendCommand(
            (new SetScheduleAttributes($this))->name((string) $name)
        );

        $this->attributes->name = (string) $name;

        return $this;
    }

    /**
     * Get description
     *
     * @return string Description of Schedule
     */
    public function getDescription()
    {
        return $this->attributes->description;
    }

    /**
     * Set descriptions
     *
     * @param string $description
     *
     * @return Schedule Self object
     */
    public function setDescription($description)
    {
        $this->client->sendCommand(
            (new SetScheduleAttributes($this))->description((string) $description)
        );

        $this->attributes->description = (string) $description;

        return $this;
    }

    /**
     * Get scheduled time
     *
     * @return string Time of schedule
     */
    public function getTime()
    {
        return $this->attributes->time;
    }

    /**
     * Set time
     *
     * @param string $time Time
     *
     * @return Schedule Self object
     */
    public function setTime($time)
    {
        // Init command
        $command = new SetScheduleAttributes($this);

        // Build new time
        $time = $command->convertTimeToUtcDate($time);

        // Update the time, and set internal attribute
        $this->client->sendCommand(
            $command->time($time)
        );

        $this->attributes->time = $time;

        return $this;
    }

    /**
     * Get command
     *
     * @return array Command attributes
     */
    public function getCommand()
    {
        return [
            'method'  => $this->attributes->command->method,
            'address' => $this->attributes->command->address,
            'body'    => $this->attributes->command->body
        ];
    }

    /**
     * Set command
     *
     * @param SchedulableInterface $command Schedulable command
     *
     * @return Schedule Self object
     */
    public function setCommand(SchedulableInterface $command)
    {
        $this->client->sendCommand(
            (new SetScheduleAttributes($this))->command($command)
        );

        $this->attributes->command = $command->getSchedulableParams($this->client);

        return $this;
    }

    /**
     * Delete schedule
     */
    public function delete()
    {
        $this->client->sendCommand(
            (new Command\DeleteSchedule($this))
        );
    }

    /**
     * __toString
     *
     * @return string Schedule Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
