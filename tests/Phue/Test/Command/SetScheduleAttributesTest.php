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
use Phue\Command\SetScheduleAttributes;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\SetScheduleAttributes
 */
class SetScheduleAttributesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->getMock('\Phue\Transport\TransportInterface', 
            array(
                'sendRequest'
            ));
        
        // Mock schedule
        $this->mockSchedule = $this->getMock('\Phue\Schedule', null, 
            array(
                12,
                new \stdClass(),
                $this->mockClient
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
            // $this->returnValue([
            // 'address' => '/thing/value',
            // 'method' => 'POST',
            // 'body' => 'Dummy'
            // ])
            $this->returnValue(
                array(
                    'address' => '/thing/value',
                    'method' => 'POST',
                    'body' => 'Dummy'
                )));
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\SetScheduleAttributes::__construct
     * @covers \Phue\Command\SetScheduleAttributes::send
     */
    public function testSend()
    {
        // Build command
        $setScheduleAttributesCmd = new SetScheduleAttributes($this->mockSchedule);
        
        // Set expected payload
        $this->stubTransportSendRequestWithPayload(
            (object) array(
                'name' => 'Dummy!',
                'description' => 'Dummy description',
                'command' => array(
                    'method' => TransportInterface::METHOD_POST,
                    'address' => "/api/{$this->mockClient->getUsername()}/thing/value",
                    'body' => "Dummy"
                )
            ));
        
        // Change name, description
        $setScheduleAttributesCmd->name('Dummy!')
            ->description('Dummy description')
            ->command($this->mockCommand)
            ->send($this->mockClient);
    }

    /**
     * Stub transport's sendRequest with an expected payload
     *
     * @param \stdClass $payload
     *            Payload
     */
    protected function stubTransportSendRequestWithPayload(\stdClass $payload)
    {
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
            $this->equalTo(
                "/api/{$this->mockClient->getUsername()}/schedules/{$this->mockSchedule->getId()}"), 
            $this->equalTo('PUT'), $payload);
    }
}
