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
        // Force default timezone
        date_default_timezone_set('UTC');

        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub attributes
        $this->attributes = (object) [
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
        $this->schedule = new Schedule(6, $this->attributes, $this->mockClient);
    }

    /**
     * Test: Getting/Setting Id
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
            $this->attributes->name
        );
    }

    /**
     * Test: Setting name
     *
     * @covers \Phue\Schedule::setName
     * @covers \Phue\Schedule::getName
     */
    public function testSetName()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Ensure setName returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setName('new name')
        );

        // Ensure new name can be retrieved by getName
        $this->assertEquals(
            $this->schedule->getName(),
            'new name'
        );
    }

    /**
     * Test: Getting description
     *
     * @covers \Phue\Schedule::getDescription
     */
    public function testGetDescription()
    {
        $this->assertEquals(
            $this->schedule->getDescription(),
            $this->attributes->description
        );
    }

    /**
     * Test: Setting description
     *
     * @covers \Phue\Schedule::setDescription
     * @covers \Phue\Schedule::getDescription
     */
    public function testSetDescription()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Ensure setDescription returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setDescription('new description')
        );

        // Ensure new description can be retrieved by getDescription
        $this->assertEquals(
            $this->schedule->getDescription(),
            'new description'
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
            $this->attributes->time
        );
    }

    /**
     * Test: Setting time
     *
     * @covers \Phue\Schedule::setTime
     * @covers \Phue\Schedule::getTime
     */
    public function testSetTime()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Ensure setTime returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setTime('2010-10-20T10:11:12')
        );

        // Ensure new time can be retrieved by getTime
        $this->assertEquals(
            $this->schedule->getTime(),
            '2010-10-20T10:11:12'
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
            (array) $this->attributes->command
        );
    }

    /**
     * Test: Settings command
     *
     * @covers \Phue\Schedule::setCommand
     * @covers \Phue\Schedule::getCommand
     */
    public function testSetCommand()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Mock schedulable command
        $mockCommand = $this->getMock(
            '\Phue\Command\SchedulableInterface',
            ['getSchedulableParams']
        );

        $schedulableParams = [
            'address' => '/api/endpoint',
            'method'  => 'POST',
            'body'    => 'Dummy'
        ];

        // Stub command's getSchedulableParams method
        $mockCommand->expects($this->any())
            ->method('getSchedulableParams')
            ->will(
                $this->returnValue((object) $schedulableParams)
            );

        // Ensure setCommand returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setCommand($mockCommand)
        );

        // Ensure new command can be retrieved by getCommand
        $this->assertEquals(
            $this->schedule->getCommand(),
            $schedulableParams
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
