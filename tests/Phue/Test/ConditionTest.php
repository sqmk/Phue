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
use Phue\Condition;

/**
 * Tests for Phue\Condition
 */
class ConditionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     *
     * @covers \Phue\Condition::__construct
     * @covers \Phue\Condition::import
     */
    public function setUp()
    {
        // $this->condition = new Condition((object) [
        // 'address' => '/sensors/2/state/buttonevent',
        // 'operator' => 'eq',
        // 'value' => '16'
        // ]);
        $this->condition = new Condition(
            (object) array(
                'address' => '/sensors/2/state/buttonevent',
                'operator' => 'eq',
                'value' => '16'
            ));
    }

    /**
     * Test: Get/set sensor id
     *
     * @covers \Phue\Condition::getSensorId
     * @covers \Phue\Condition::setSensorId
     */
    public function testGetSetSensorId()
    {
        $this->assertEquals('2', $this->condition->getSensorId());
        
        $this->condition->setSensorId('3');
        
        $this->assertEquals('3', $this->condition->getSensorId());
    }

    /**
     * Test: Get/set attribute
     *
     * @covers \Phue\Condition::getAttribute
     * @covers \Phue\Condition::setAttribute
     */
    public function testGetSetAttribute()
    {
        $this->assertEquals('buttonevent', $this->condition->getAttribute());
        
        $this->condition->setAttribute('dummy');
        
        $this->assertEquals('dummy', $this->condition->getAttribute());
    }

    /**
     * Test: Get/set operator
     *
     * @covers \Phue\Condition::getOperator
     * @covers \Phue\Condition::setOperator
     */
    public function testGetSetOperator()
    {
        $this->assertEquals('eq', $this->condition->getOperator());
        
        $this->condition->setOperator('dx');
        
        $this->assertEquals('dx', $this->condition->getOperator());
    }

    /**
     * Test: Get/set value
     *
     * @covers \Phue\Condition::getValue
     * @covers \Phue\Condition::setValue
     */
    public function testGetSetValue()
    {
        $this->assertEquals('16', $this->condition->getValue());
        
        $this->condition->setValue('20');
        
        $this->assertEquals('20', $this->condition->getValue());
    }

    /**
     * Test: Export
     *
     * @covers \Phue\Condition::export
     */
    public function testExport()
    {
        $this->assertEquals(
            // TODO (object) [
            // 'address' => '/sensors/2/state/buttonevent',
            // 'operator' => 'eq',
            // 'value' => '16'
            // ],
            (object) array(
                'address' => '/sensors/2/state/buttonevent',
                'operator' => 'eq',
                'value' => '16'
            ), $this->condition->export());
    }

    /**
     * Test: Equals
     *
     * @covers \Phue\Condition::equals
     */
    public function testEquals()
    {
        $this->condition->equals();
        
        $this->assertEquals(Condition::OPERATOR_EQUALS, 
            $this->condition->getOperator());
    }

    /**
     * Test: Greater than
     *
     * @covers \Phue\Condition::greaterThan
     */
    public function testGreaterThan()
    {
        $this->condition->greaterThan();
        
        $this->assertEquals(Condition::OPERATOR_GREATER_THAN, 
            $this->condition->getOperator());
    }

    /**
     * Test: Less than
     *
     * @covers \Phue\Condition::lessThan
     */
    public function testLessThan()
    {
        $this->condition->lessThan();
        
        $this->assertEquals(Condition::OPERATOR_LESS_THAN, 
            $this->condition->getOperator());
    }

    /**
     * Test: Changed
     *
     * @covers \Phue\Condition::changed
     */
    public function testChanged()
    {
        $this->condition->changed();
        
        $this->assertEquals(Condition::OPERATOR_CHANGED, 
            $this->condition->getOperator());
    }
}
