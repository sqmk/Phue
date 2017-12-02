<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue;

use Phue\Command\ActionableInterface;
use Phue\Command\SetScheduleAttributes;
use Phue\TimePattern\AbsoluteTime;

/**
 * Schedule object
 */
class Schedule
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
     * @var string
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
     * @param string $id
     *            Id
     * @param \stdClass $attributes
     *            Schedule attributes
     * @param Client $client
     *            Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id = (string) $id;
        $this->attributes = $attributes;
        $this->client = $client;
    }

    /**
     * Get schedule Id
     *
     * @return string Schedule id
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
     *
     * @return self This object
     */
    public function setName($name)
    {
        $x = new SetScheduleAttributes($this);
        $y = $x->name((string) $name);
        $this->client->sendCommand($y);
        
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
     * Set description
     *
     * @param string $description
     *
     * @return self This object
     */
    public function setDescription($description)
    {
        $x = new SetScheduleAttributes($this);
        $y = $x->description((string) $description);
        $this->client->sendCommand($y);
        
        $this->attributes->description = (string) $description;
        
        return $this;
    }

    /**
     * Get command
     *
     * @return array Command attributes
     */
    public function getCommand()
    {
        return (array) $this->attributes->command;
    }

    /**
     * Set command
     *
     * @param ActionableInterface $command
     *            Actionable command
     *
     * @return self This object
     */
    public function setCommand(ActionableInterface $command)
    {
        $x = new SetScheduleAttributes($this);
        $y = $x->command($command);
        $this->client->sendCommand($y);
        
        $this->attributes->command = $command->getActionableParams($this->client);
        
        return $this;
    }

    /**
     * Get status
     *
     * @return string Get status.
     */
    public function getStatus()
    {
        return $this->attributes->status;
    }

    /**
     * Set status.
     *
     * @param string $status
     *            Status.
     *
     * @return self This object
     */
    public function setStatus($status)
    {
        $x = new SetScheduleAttributes($this);
        $y = $x->status((string) $status);
        $this->client->sendCommand($y);
        
        $this->attributes->status = (string) $status;
        
        return $this;
    }

    /**
     * Is schedule enabled.
     *
     * @return bool True if enabled, false if not.
     */
    public function isEnabled()
    {
        return $this->attributes->status == self::STATUS_ENABLED;
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
     * @param string $time
     *            Time
     *
     * @return self This object
     */
    public function setTime($time)
    {
        // $this->client->sendCommand(
        // (new SetScheduleAttributes($this))
        // ->time($time)
        // );
        $x = new SetScheduleAttributes($this);
        $y = $x->time($time);
        $this->client->sendCommand($y);
        
        $this->attributes->time = (string) $time;
        
        return $this;
    }

    /**
     * Is auto deleted?
     *
     * @return bool True if auto delete, false if not
     */
    public function isAutoDeleted()
    {
        return (bool) $this->attributes->autodelete;
    }

    /**
     * Set auto delete
     *
     * @param bool $flag
     *            True to auto delete, false if not
     *
     * @return self This object
     */
    public function setAutoDelete($flag)
    {
        $x = new SetScheduleAttributes($this);
        $y = $x->autodelete((bool) $flag);
        $this->client->sendCommand($y);
        
        $this->attributes->autodelete = (bool) $flag;
        
        return $this;
    }

    /**
     * Delete schedule
     */
    public function delete()
    {
        $this->client->sendCommand((new Command\DeleteSchedule($this)));
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
