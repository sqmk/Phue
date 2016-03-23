<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test\Command;

use Mockery;
use Phue\Client;
use Phue\Command\CreateRule;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\CreateRule
 */
class CreateRuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test: Instantiating CreateRule command
     *
     * @covers \Phue\Command\CreateRule::__construct
     */
    public function testInstantiation()
    {
        $command = new CreateRule('dummy name');
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateRule::name
     */
    public function testName()
    {
        $command = new CreateRule();
        
        $this->assertEquals($command, $command->name('dummy name'));
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateRule::addCondition
     */
    public function testAddCondition()
    {
        $condition = Mockery::mock('\Phue\Condition')->makePartial();
        
        $command = new CreateRule();
        
        $this->assertEquals($command, $command->addCondition($condition));
    }

    /**
     * Test: Set name
     *
     * @covers \Phue\Command\CreateRule::addAction
     */
    public function testAddAction()
    {
        $action = Mockery::mock('\Phue\Command\ActionableInterface')->makePartial();
        
        $command = new CreateRule();
        
        $this->assertEquals($command, $command->addAction($action));
    }

    /**
     * Test: Send
     *
     * @covers \Phue\Command\CreateRule::send
     */
    public function testSend()
    {
        // Mock client
        $mockClient = Mockery::mock('\Phue\Client', 
            array(
                'getUsername' => 'abcdefabcdef01234567890123456789'
            ))->makePartial();
        
        // Mock client commands
        $mockClient->shouldReceive('getTransport->sendRequest')->
        andReturn((object) array(
            'id' => '5'
        ));
        
        $x = new CreateRule('test');
        $command = $x->addCondition(Mockery::mock('\Phue\Condition')->makePartial())
            ->addAction(
            Mockery::mock('\Phue\Command\ActionableInterface')->shouldIgnoreMissing());
        
        $this->assertEquals('5', $command->send($mockClient));
    }
}
