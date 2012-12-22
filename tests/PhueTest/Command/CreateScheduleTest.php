<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest\Command;

use Phue\Command\CreateSchedule;
use Phue\Client;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\CreateSchedule
 *
 * @category Phue
 * @package  Phue
 */
class CreateScheduleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        // Ensure proper timezone
        date_default_timezone_set('UTC');

        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getUsername', 'getTransport'],
            ['127.0.0.1']
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
            ['sendRequest']
        );

        // Stub client's getUsername method
        $this->mockClient->expects($this->any())
                         ->method('getUsername')
                         ->will($this->returnValue('abcdefabcdef01234567890123456789'));

        // Stub client's getTransport method
        $this->mockClient->expects($this->any())
                         ->method('getTransport')
                         ->will($this->returnValue($this->mockTransport));

        // Mock schedulable command
        $this->mockCommand = $this->getMock(
            '\Phue\Command\SchedulableInterface',
            ['getSchedulableParams']
        );

        // Stub command's getSchedulableParams method
        $this->mockCommand->expects($this->any())
                          ->method('getSchedulableParams')
                          ->will($this->returnValue([
                              'address' => '/api/endpoint',
                              'method'  => 'POST',
                              'body'    => 'Dummy'
                          ]));
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateSchedule::name
     */
    public function testName()
    {
        $command = (new CreateSchedule())->name('Dummy!');

        // Ensure property is set properly
        $this->assertAttributeEquals(
            'Dummy!',
            'name',
            $command
        );

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
        $command = (new CreateSchedule())->description('Description!');

        // Ensure property is set properly
        $this->assertAttributeEquals(
            'Description!',
            'description',
            $command
        );

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
        $command = (new CreateSchedule())->time('2010-20-10T10:11:12');

        // Ensure property is set properly
        $this->assertAttributeEquals(
            '2010-20-10T10:11:12',
            'time',
            $command
        );

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
        $command = (new CreateSchedule())->command($this->mockCommand);

        // Ensure properties are set properly
        $this->assertAttributeEquals(
           $this->mockCommand,
            'command',
            $command
        );

        // Ensure self object is returned
        $this->assertEquals($command, $command->time('+10 seconds'));
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\CreateSchedule::__construct
     * @covers \Phue\Command\CreateSchedule::convertTimeToUtcDate
     * @covers \Phue\Command\CreateSchedule::send
     */
    public function testSend()
    {
        $command = new CreateSchedule('Dummy!', '2012-12-30T10:11:12', $this->mockCommand);
        $command->description('Description!');

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
                            ->method('sendRequest')
                            ->with(
                                $this->equalTo("{$this->mockClient->getUsername()}/schedules"),
                                $this->equalTo(TransportInterface::METHOD_POST),
                                $this->equalTo((object) [
                                    'name'        => 'Dummy!',
                                    'description' => 'Description!',
                                    'time'        => '2012-12-30T10:11:12',
                                    'command'     => [
                                        'method'  => TransportInterface::METHOD_POST,
                                        'address' => "/api/endpoint",
                                        'body'    => "Dummy"
                                    ]
                                ])
                            )
                            ->will($this->returnValue(4));

        // Send command and get response
        $scheduleId = $command->send($this->mockClient);

        // Ensure we have a schedule id
        $this->assertEquals($scheduleId, 4);
    }
}
