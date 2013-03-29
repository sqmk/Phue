<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

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
     * Schedule details
     *
     * @var stdClass
     */
    protected $details;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Schedule object
     *
     * @param int      $id      Id
     * @param stdClass $details Schedule details
     * @param Client   $client  Phue client
     */
    public function __construct($id, \stdClass $details, Client $client)
    {
        $this->id      = (int) $id;
        $this->details = $details;
        $this->client  = $client;
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
        return $this->details->name;
    }

    /**
     * Get description
     *
     * @return string Description of Schedule
     */
    public function getDescription()
    {
        return $this->details->description;
    }

    /**
     * Get scheduled time
     *
     * @return string Time of schedule
     */
    public function getTime()
    {
        return $this->details->time;
    }

    /**
     * Get command
     *
     * @return array Command details
     */
    public function getCommand()
    {
        return [
            'method'  => $this->details->command->method,
            'address' => $this->details->command->address,
            'body'    => $this->details->command->body
        ];
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
