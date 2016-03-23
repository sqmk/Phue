<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\Command;

use Phue\Client;
use Phue\Command\CreateSchedule;
use Phue\Schedule;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\CreateSchedule
 */
class CreateScheduleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        // Ensure proper timezone
        date_default_timezone_set('UTC');
        
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'getUsername',
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->getMock('\Phue\Transport\TransportInterface', 
            array(
                'sendRequest'
            ));
        
        // Stub client's getUsername method
        $this->mockClient->expects($this->any())
            ->method('getUsername')
            ->will($this->returnValue('abcdefabcdef01234567890123456789'));
        
        // Stub client's getTransport method
        $this->mockClient->expects($this->any())
            ->method('getTransport')
            ->will($this->returnValue($this->mockTransport));
        
        // Mock actionable command
        $this->mockCommand = $this->getMock('\Phue\Command\ActionableInterface', 
            array(
                'getActionableParams'
            ));
        
        // Stub command's getActionableParams method
        $this->mockCommand->expects($this->any())
            ->method('getActionableParams')
            ->will(
            $this->returnValue(
                array(
                    'address' => '/thing/value',
                    'method' => 'POST',
                    'body' => 'Dummy'
                )));
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateSchedule::name
     */
    public function testName()
    {
        $x = new CreateSchedule();
        $command = $x->name('Dummy!');
        
        // Ensure property is set properly
        $this->assertAttributeContains('Dummy!', 'attributes', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->name('Dummy!'));
    }

    /**
     * Test: Set description
     *
     * @covers \Phue\Command\CreateSchedule::description
     */
    public function testDescription()
    {
        $x = new CreateSchedule();
        $command = $x->description('Description!');
        
        // Ensure property is set properly
        $this->assertAttributeContains('Description!', 'attributes', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->name('Description!'));
    }

    /**
     * Test: Set time
     *
     * @covers \Phue\Command\CreateSchedule::time
     */
    public function testTime()
    {
        $x = new CreateSchedule();
        $command = $x->time('2010-10-20T10:11:12');
        
        // Ensure property is set properly
        $this->assertAttributeInstanceOf('\Phue\TimePattern\TimePatternInterface', 
            'time', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->time('+10 seconds'));
    }

    /**
     * Test: Set command
     *
     * @covers \Phue\Command\CreateSchedule::command
     */
    public function testCommand()
    {
        $x = new CreateSchedule();
        $command = $x->command($this->mockCommand);
        
        // Ensure properties are set properly
        $this->assertAttributeEquals($this->mockCommand, 'command', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->command($this->mockCommand));
    }

    /**
     * Test: Set status
     *
     * @covers \Phue\Command\CreateSchedule::status
     */
    public function testStatus()
    {
        $x = new CreateSchedule();
        $command = $x->status(Schedule::STATUS_ENABLED);
        
        // Ensure property is set properly
        $this->assertAttributeContains(Schedule::STATUS_ENABLED, 'attributes', 
            $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->status(Schedule::STATUS_ENABLED));
    }

    /**
     * Test: Auto delete
     *
     * @covers \Phue\Command\CreateSchedule::autodelete
     */
    public function testAutoDelete()
    {
        $x = new CreateSchedule();
        $command = $x->autodelete(true);
        // Ensure property is set properly
        $this->assertAttributeContains(true, 'attributes', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->autodelete(true));
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\CreateSchedule::__construct
     * @covers \Phue\Command\CreateSchedule::send
     */
    public function testSend()
    {
        $command = new CreateSchedule('Dummy!', '2012-12-30T10:11:12', 
            $this->mockCommand);
        $command->description('Description!');
        
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
            $this->equalTo("/api/{$this->mockClient->getUsername()}/schedules"), 
            $this->equalTo(TransportInterface::METHOD_POST), 
            $this->equalTo(
                (object) array(
                    'name' => 'Dummy!',
                    'description' => 'Description!',
                    'time' => '2012-12-30T10:11:12',
                    'command' => array(
                        'method' => TransportInterface::METHOD_POST,
                        'address' => "/api/{$this->mockClient->getUsername()}/thing/value",
                        'body' => "Dummy"
                    )
                )))
            ->will($this->returnValue(4));
        
        // Send command and get response
        $scheduleId = $command->send($this->mockClient);
        
        // Ensure we have a schedule id
        $this->assertEquals(4, $scheduleId);
    }
}
