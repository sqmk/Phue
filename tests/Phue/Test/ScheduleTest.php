<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test;

use Phue\Client;
use Phue\Schedule;

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
// TODO             ['sendCommand'],
//             ['127.0.0.1']
            array('sendCommand'),
            array('127.0.0.1')
        		);

        // Build stub attributes
// TODO         $this->attributes = (object) [
//             'name'        => 'Dummy schedule',
//             'description' => 'Dummy description',
//             'time'        => '12-30-2012T01:02:03',
//             'command'     => (object) [
//                 'method'  => 'POST',
//                 'address' => 'api/something',
//                 'body'    => 'body!'
//             ],
//             'status'      => Schedule::STATUS_ENABLED,
//             'autodelete'  => false,
//         ];
        $this->attributes = (object) array(
        		'name'        => 'Dummy schedule',
        		'description' => 'Dummy description',
        		'time'        => '12-30-2012T01:02:03',
        		'command'     => (object) array(
        				'method'  => 'POST',
        				'address' => 'api/something',
        				'body'    => 'body!'
        		),
        		'status'      => Schedule::STATUS_ENABLED,
        		'autodelete'  => false,
        );
        
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
            6,
            $this->schedule->getId()
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
            $this->attributes->name,
            $this->schedule->getName()
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
            'new name',
            $this->schedule->getName()
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
            $this->attributes->description,
            $this->schedule->getDescription()
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
            'new description',
            $this->schedule->getDescription()
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
            $this->attributes->time,
            $this->schedule->getTime()
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
            '2010-10-20T10:11:12',
            $this->schedule->getTime()
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
            (array) $this->attributes->command,
            $this->schedule->getCommand()
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

        // Mock actionable command
        $mockCommand = $this->getMock(
            '\Phue\Command\ActionableInterface',
// TODO            ['getActionableParams']
            array('getActionableParams')
        		);

// TODO         $actionableParams = [
//             'address' => '/api/endpoint',
//             'method'  => 'POST',
//             'body'    => 'Dummy'
//         ];
        $actionableParams = array(
        		'address' => '/api/endpoint',
        		'method'  => 'POST',
        		'body'    => 'Dummy'
        );
        
        // Stub command's getActionableParams method
        $mockCommand->expects($this->any())
            ->method('getActionableParams')
            ->will(
                $this->returnValue((object) $actionableParams)
            );

        // Ensure setCommand returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setCommand($mockCommand)
        );

        // Ensure new command can be retrieved by getCommand
        $this->assertEquals(
            $actionableParams,
            $this->schedule->getCommand()
        );
    }

    /**
     * Test: Getting status
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::getStatus
     */
    public function testGetStatus()
    {
        $this->assertEquals(
            $this->attributes->status,
            $this->schedule->getStatus()
        );
    }

    /**
     * Test: Setting status
     *
     * @covers \Phue\Schedule::setStatus
     * @covers \Phue\Schedule::getStatus
     */
    public function testSetStatus()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Ensure setStatus returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setStatus(Schedule::STATUS_ENABLED)
        );

        // Ensure new status can be retrieved by getStatus
        $this->assertEquals(
            Schedule::STATUS_ENABLED,
            $this->schedule->getStatus()
        );
    }

    /**
     * Test: Is enabled
     *
     * @covers \Phue\Schedule::isEnabled
     */
    public function testIsEnabled()
    {
        $this->assertTrue(
            $this->schedule->isEnabled()
        );
    }

    /**
     * Test: Is autodeleted
     *
     * @covers \Phue\Schedule::__construct
     * @covers \Phue\Schedule::isAutoDeleted
     */
    public function testIsAutoDeleted()
    {
        $this->assertEquals(
            $this->attributes->autodelete,
            $this->schedule->isAutoDeleted()
        );
    }

    /**
     * Test: Setting autodelete
     *
     * @covers \Phue\Schedule::setAutoDelete
     * @covers \Phue\Schedule::isAutoDeleted
     */
    public function testSetAutoDelete()
    {
        // Stub client's sendCommand method
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetScheduleAttributes'))
            ->will($this->returnValue($this->schedule));

        // Ensure setAutoDelete returns self
        $this->assertEquals(
            $this->schedule,
            $this->schedule->setAutoDelete(true)
        );

        // Ensure autodelete can be retrieved by isAutoDeleted
        $this->assertEquals(
            true,
            $this->schedule->isAutoDeleted()
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
            $this->schedule->getId(),
            (string) $this->schedule
        );
    }
}
