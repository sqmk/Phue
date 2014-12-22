<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012-2014 Michael K. Squires
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
        $this->assertAttributeEquals(
            'phue-test',
            'id',
            $command
        );

        // Ensure self object is returned
        $this->assertEquals(
            $command,
            $command->id('phue-test')
        );
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
        $this->assertAttributeEquals(
            'Scene test',
            'name',
            $command
        );

        // Ensure self object is returned
        $this->assertEquals(
            $command,
            $command->name('Scene test')
        );
    }

    /**
     * Test: Set lights
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::lights
     */
    public function testLights()
    {
        $command = new CreateScene('phue-test', 'Scene test', [1, 2]);

        // Ensure property is set properly
        $this->assertAttributeEquals(
            [1, 2],
            'lights',
            $command
        );

        // Ensure self object is returned
        $this->assertEquals($command, $command->lights([1]));
    }

    /**
     * Test: Send command
     *
     * @covers \Phue\Command\CreateScene::__construct
     * @covers \Phue\Command\CreateScene::send
     */
    public function testSend()
    {
        $command = new CreateScene('phue-test', 'Scene test', [2, 3]);

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->equalTo("/api/{$this->mockClient->getUsername()}/scenes/phue-test"),
                $this->equalTo(TransportInterface::METHOD_PUT),
                $this->equalTo(
                    (object) [
                        'name'   => 'Scene test',
                        'lights' => [2, 3]
                    ]
                )
            );

        // Send command
        $command->send($this->mockClient);
    }
}
