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
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;
use Phue\Command\SchedulableInterface;

/**
 * Create schedule command
 *
 * @category Phue
 * @package  Phue
 */
class CreateSchedule implements CommandInterface
{
    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Description
     *
     * @var string
     */
    protected $description;

    /**
     * Time
     *
     * @var string
     */
    protected $time;

    /**
     * Command
     *
     * @var SchedulableInterface
     */
    protected $command;

    /**
     * Constructs a create schedule command
     *
     * @param string                $name    Name of schedule
     * @param string                $time    Time to run command
     * @param SchedulableInterface  $command Schedulable command
     *
     * @return void
     */
    public function __construct(
        $name = null,
        $time = null,
        SchedulableInterface $command = null
    ) {
        // Set name, time, command if passed
        $name    !== null && $this->name($name);
        $time    !== null && $this->time($time);
        $command !== null && $this->command($command);

        // Copy description
        $this->description = $this->name;
    }

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return CreateSchedule Self object
     */
    public function name($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return CreateSchedule Self object
     */
    public function description($description)
    {
        $this->description = (string) $description;

        return $this;
    }

    /**
     * Set time
     *
     * @param string $time Time
     *
     * @return CreateSchedule Self object
     */
    public function time($time)
    {
        $this->time = $this->convertTimeToUtcDate(
            (string) $time
        );

        return $this;
    }

    /**
     * Set command
     *
     * @param SchedulableInterface $command Schedulable command
     *
     * @return CreateSchedule Self object
     */
    public function command(SchedulableInterface $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return int Group Id
     */
    public function send(Client $client)
    {
        $scheduleId = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/schedules",
            TransportInterface::METHOD_POST,
            (object) [
                'name'        => $this->name,
                'description' => $this->description,
                'time'        => $this->time,
                'command'     => $this->command->getSchedulableParams($client)
            ]
        );

        return $scheduleId;
    }

    /**
     * Convert time to UTC date
     *
     * @param string $time Time to convert
     *
     * @return string
     */
    protected function convertTimeToUtcDate($time)
    {
        try {
            $setTime = new \DateTime($time);
            $setTime->setTimeZone(
                new \DateTimeZone('UTC')
            );
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('time value could not be parsed');
        }

        return $setTime->format('Y-m-d\TH:i:s');
    }
}
