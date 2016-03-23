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
use Phue\Rule;

/**
 * Tests for Phue\Rule
 */
class RuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     *
     * @covers \Phue\Rule::__construct
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'sendCommand'
            ), array(
                '127.0.0.1'
            ));
        
        // Build stub attributes
        // $this->attributes = (object) [
        // 'name' => 'Wall Switch Rule',
        // 'lasttriggered' => '2013-10-17T01:23:20',
        // 'created' => '2013-10-10T21:11:45',
        // 'timestriggered' => 27,
        // 'owner' => '78H56B12BA',
        // 'status' => 'enabled',
        // 'conditions' => [
        // (object) [
        // 'address' => '/sensors/2/state/buttonevent',
        // 'operator' => 'eq',
        // 'value' => '16'
        // ],
        // (object) [
        // 'address' => '/sensors/2/state/lastupdated',
        // 'operator' => 'dx'
        // ]
        // ],
        // 'actions' => [
        // (object) [
        // 'address' => '/groups/0/action',
        // 'method' => 'PUT',
        // 'body' => [
        // 'scene' => 'S3'
        // ]
        // ]
        // ]
        // ];
        $this->attributes = (object) array(
            'name' => 'Wall Switch Rule',
            'lasttriggered' => '2013-10-17T01:23:20',
            'created' => '2013-10-10T21:11:45',
            'timestriggered' => 27,
            'owner' => '78H56B12BA',
            'status' => 'enabled',
            'conditions' => array(
                (object) array(
                    'address' => '/sensors/2/state/buttonevent',
                    'operator' => 'eq',
                    'value' => '16'
                ),
                (object) array(
                    'address' => '/sensors/2/state/lastupdated',
                    'operator' => 'dx'
                )
            ),
            'actions' => array(
                (object) array(
                    'address' => '/groups/0/action',
                    'method' => 'PUT',
                    'body' => array(
                        'scene' => 'S3'
                    )
                )
            )
        );
        
        // Create rule object
        $this->rule = new Rule(4, $this->attributes, $this->mockClient);
    }

    /**
     * Test: Getting Id
     *
     * @covers \Phue\Rule::getId
     */
    public function testGetId()
    {
        $this->assertEquals(4, $this->rule->getId());
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Rule::getName
     */
    public function testGetName()
    {
        $this->assertEquals($this->attributes->name, $this->rule->getName());
    }

    /**
     * Test: Getting last triggered time
     *
     * @covers \Phue\Rule::getLastTriggeredTime
     */
    public function testGetLastTriggeredTime()
    {
        $this->assertEquals($this->attributes->lasttriggered, 
            $this->rule->getLastTriggeredTime());
    }

    /**
     * Test: Getting create date
     *
     * @covers \Phue\Rule::getCreateDate
     */
    public function testGetCreateDate()
    {
        $this->assertEquals($this->attributes->created, $this->rule->getCreateDate());
    }

    /**
     * Test: Getting triggered count
     *
     * @covers \Phue\Rule::getTriggeredCount
     */
    public function testGetTriggeredCount()
    {
        $this->assertEquals($this->attributes->timestriggered, 
            $this->rule->getTriggeredCount());
    }

    /**
     * Test: Get owner
     *
     * @covers \Phue\Rule::getOwner
     */
    public function testGetOwner()
    {
        $this->assertEquals($this->attributes->owner, $this->rule->getOwner());
    }

    /**
     * Test: Is enabled?
     *
     * @covers \Phue\Rule::isEnabled
     */
    public function testIsEnabled()
    {
        return $this->assertTrue($this->rule->isEnabled());
    }

    /**
     * Test: Get conditions
     *
     * @covers \Phue\Rule::getConditions
     */
    public function testGetConditions()
    {
        $conditions = $this->rule->getConditions();
        
        $this->assertEquals(2, count($conditions));
        
        $this->assertContainsOnlyInstancesOf('\Phue\Condition', $conditions);
    }

    /**
     * Test: Get actions
     *
     * @covers \Phue\Rule::getActions
     */
    public function testGetActions()
    {
        $actions = $this->rule->getActions();
        
        $this->assertEquals(1, count($actions));
        
        $this->assertContainsOnlyInstancesOf('\stdClass', $actions);
    }

    /**
     * Test: Delete
     *
     * @covers \Phue\Rule::delete
     */
    public function testDelete()
    {
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\DeleteRule'));
        
        $this->rule->delete();
    }

    /**
     * Test: toString
     *
     * @covers \Phue\Rule::__toString
     */
    public function testToString()
    {
        $this->assertEquals($this->rule->getId(), (string) $this->rule);
    }
}
