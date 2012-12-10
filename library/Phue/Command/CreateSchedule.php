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
use Phue\Transport\Http;
use Phue\Command\CommandInterface;

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
     * @var \stdClass
     */
    protected $command;

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
        $this->time = (string) $time;

        return $this;
    }

    /**
     * Set command
     *
     * @param string $address Address
     * @param mixed  $method  Method
     * @param string $body    Body
     *
     * @return CreateSchedule Self object
     */
    public function command($address = '', $method = Http::METHOD_GET, $body)
    {
        $this->command = (object) [
            'method'  => $method,
            'address' => $address,
            'body'    => $body
        ];

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
        $setTime = new \DateTime($this->time);
        $setTime->setTimeZone(
            new \DateTimeZone('UTC')
        );

        $scheduleId = $client->getTransport()->sendRequest(
            "{$client->getUsername()}/schedules",
            Http::METHOD_POST,
            (object) [
                'name'        => $this->name,
                'description' => $this->description,
                'time'        => $setTime->format('Y-m-d\TH:i:s'),
                'command'     => $this->command
            ]
        );

        return $scheduleId;
    }
}
