<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest;

use Phue\Schedule;
use Phue\Client;

/**
 * Tests for Phue\Schedule
 */
class ScheduleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub details
        $this->details = (object) [
            'name'        => 'Dummy schedule',
            'description' => 'Dummy description',
            'time'        => '12-30-2012T01:02:03',
            'command'     => (object) [
                'method'  => 'POST',
                'address' => 'api/something',
                'body'    => 'body!'
            ]
        ];

        // Create schedule object
        $this->schedule = new Schedule(6, $this->details, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getId
     */
    public function testGetId()
    {
        $this->assertEquals(
            $this->schedule->getId(),
            6
        );
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            $this->schedule->getName(),
            $this->details->name
        );
    }

    /**
     * Test: Getting description
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getDescription
     */
    public function testGetDescription()
    {
        $this->assertEquals(
            $this->schedule->getDescription(),
            $this->details->description
        );
    }

    /**
     * Test: Getting time
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getTime
     */
    public function testGetTime()
    {
        $this->assertEquals(
            $this->schedule->getTime(),
            $this->details->time
        );
    }


    /**
     * Test: Getting command
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getCommand
     */
    public function testGetCommand()
    {
        $this->assertEquals(
            $this->schedule->getCommand(),
            (array) $this->details->command
        );
    }

    /**
     * Test: Delete
     *
     * @covers \Phue\Schedule::delete
     */
    public function testDelete()
    {
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\DeleteSchedule'));

        $this->schedule->delete();
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Schedule::__toString
     */
    public function testToString()
    {
        $this->assertEquals(
            (string) $this->schedule,
            $this->schedule->getId()
        );
    }
}
