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
use Phue\Command\CreateScene;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\CreateScene
 */
class CreateSceneTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            // TODO ['getUsername', 'getTransport'],
            // ['127.0.0.1']
            array(
                'getUsername',
                'getTransport'
            ), array(
                '127.0.0.1'
            ));
        
        // Mock transport
        $this->mockTransport = $this->getMock('\Phue\Transport\TransportInterface', 
            // TODO ['sendRequest']
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
    }

    /**
     * Test: Set Id
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::id
     */
    public function testId()
    {
        $command = new CreateScene('phue-test', 'Scene test');
        
        // Ensure property is set properly
        $this->assertAttributeEquals('phue-test', 'id', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->id('phue-test'));
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::name
     */
    public function testName()
    {
        $command = new CreateScene('phue-test', 'Scene test');
        
        // Ensure property is set properly
        $this->assertAttributeEquals('Scene test', 'name', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->name('Scene test'));
    }

    /**
     * Test: Set lights
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::lights
     */
    public function testLights()
    {
        // TODO $command = new CreateScene('phue-test', 'Scene test', [1, 2]);
        $command = new CreateScene('phue-test', 'Scene test', array(
            1,
            2
        ));
        
        // Ensure property is set properly
        $this->assertAttributeEquals(
            // TODO [1, 2],
            array(
                1,
                2
            ), 'lights', $command);
        
        // Ensure self object is returned
        // TODO $this->assertEquals($command, $command->lights([1]));
        $this->assertEquals($command, $command->lights(array(
            1
        )));
    }

    /**
     * Test: Set transition time
     *
     * @covers \Phue\Command\CreateScene::transitionTime
     */
    public function testTransitionTime()
    {
        // TODO $command = new CreateScene('phue-test', 'Scene test', [1, 2]);
        $command = new CreateScene('phue-test', 'Scene test', array(
            1,
            2
        ));
        $command->transitionTime(2);
        
        // Ensure property is set properly
        $this->assertAttributeEquals(20, 'transitionTime', $command);
        
        // Ensure self object is returned
        $this->assertEquals($command, $command->transitionTime(1));
    }

    /**
     * Test: Setting invalid transition time
     *
     * @covers \Phue\Command\CreateScene::transitionTime
     *
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionOnInvalidTransitionTime()
    {
        // TODO $command = new CreateScene('phue-test', 'Scene test', [1, 2]);
        $command = new CreateScene('phue-test', 'Scene test', array(
            1,
            2
        ));
        $command->transitionTime(- 1);
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::send
     */
    public function testSend()
    {
        // TODO $command = new CreateScene('phue-test', 'Scene test', [2, 3]);
        $command = new CreateScene('phue-test', 'Scene test', array(
            2,
            3
        ));
        $command->transitionTime(5);
        
        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
            $this->equalTo(
                "/api/{$this->mockClient->getUsername()}/scenes/phue-test"), 
            $this->equalTo(TransportInterface::METHOD_PUT), 
            $this->equalTo(
                // TODO (object) [
                // 'name' => 'Scene test',
                // TODO 'lights' => [2, 3],
                // 'transitiontime' => 50,
                // ]
                (object) array(
                    'name' => 'Scene test',
                    'lights' => array(
                        2,
                        3
                    ),
                    'transitiontime' => 50
                )));
        
        // Send command
        $command->send($this->mockClient);
    }
}
