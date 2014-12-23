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
use Phue\Portal;

/**
 * Tests for Phue\Portal
 */
class PortalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @covers \Phue\Portal::__construct
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub attributes
        $this->attributes = (object) [
            'signedon'      => true,
            'incoming'      => false,
            'outgoing'      => true,
            'communication' => 'disconnected'
        ];

        // Create portal object
        $this->portal = new Portal($this->attributes, $this->mockClient);
    }

    /**
     * Test: Is signed on?
     *
     * @covers \Phue\Portal::isSignedOn
     */
    public function testIsSignedOn()
    {
        $this->assertEquals(
            $this->attributes->signedon,
            $this->portal->isSignedOn()
        );
    }

    /**
     * Test: Is incoming?
     *
     * @covers \Phue\Portal::isIncoming
     */
    public function testIsIncoming()
    {
        $this->assertEquals(
            $this->attributes->incoming,
            $this->portal->isIncoming()
        );
    }

    /**
     * Test: Is outgoing?
     *
     * @covers \Phue\Portal::isOuting
     */
    public function testIsOutgoing()
    {
        $this->assertEquals(
            $this->attributes->outgoing,
            $this->portal->isOutgoing()
        );
    }

    /**
     * Test: Getting communication
     *
     * @covers \Phue\Portal::getCommunication
     */
    public function testGetCommunication()
    {
        $this->assertEquals(
            $this->attributes->communication,
            $this->portal->getCommunication()
        );
    }
}
