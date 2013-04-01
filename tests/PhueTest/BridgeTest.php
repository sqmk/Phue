<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace PhueTest;

use Phue\Bridge;
use Phue\Client;

/**
 * Tests for Phue\Bridge
 */
class BridgeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['sendCommand'],
            ['127.0.0.1']
        );

        // Build stub details
        $this->details = (object) [
            'name'           => 'Hue Bridge',
            'mac'            => '00:11:22:33:44:55',
            'dhcp'           => true,
            'ipaddress'      => '127.0.0.1',
            'netmask'        => '255.255.255.0',
            'gateway'        => '10.0.1.0',
            'proxyaddress'   => '123.123.123.123',
            'proxyport'      => '999',
            'UTC'            => 'somedate',
            'swversion'      => '12345',
            'whitelist'      => [
                'abcdefabcdef01234567890123456789' => (object) [
                    'name'          => 'Client name',
                    'create date'   => '12-30-2000',
                    'last use date' => '12-30-2001',
                ]
            ],
            'linkbutton'     => true,
            'portalservices' => false,
        ];

        // Create bridge object
        $this->bridge = new Bridge($this->details, $this->mockClient);
    }

    /**
     * Test: Getting name
     *
     * @covers \Phue\Bridge::__construct
     * @covers \Phue\Bridge::getName
     */
    public function testGetName()
    {
        $this->assertEquals(
            $this->bridge->getName(),
            $this->details->name
        );
    }

    /**
     * Test: Setting name
     *
     * @covers \Phue\Bridge::setName
     */
    public function testSetName()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
                         ->method('sendCommand')
                         ->with($this->isInstanceOf('\Phue\Command\SetBridgeConfig'))
                         ->will($this->returnValue($this->bridge));

        // Ensure setName returns self
        $this->assertEquals(
            $this->bridge,
            $this->bridge->setName('new name')
        );

        // Ensure new name can be retrieved by getName
        $this->assertEquals(
            $this->bridge->getName(),
            'new name'
        );
    }

    /**
     * Test: Getting MAC address
     *
     * @covers \Phue\Bridge::getMacAddress
     */
    public function testGetMacAddress()
    {
        $this->assertEquals(
            $this->bridge->getMacAddress(),
            $this->details->mac
        );
    }

    /**
     * Test: Is DHCP enabled?
     *
     * @covers \Phue\Bridge::isDhcpEnabled
     */
    public function testIsDhcpEnabled()
    {
        $this->assertTrue(
            $this->bridge->isDhcpEnabled()
        );
    }

    /**
     * Test: Getting IP Address
     *
     * @covers \Phue\Bridge::getIpAddress
     */
    public function testGetIpAddress()
    {
        $this->assertEquals(
            $this->bridge->getIpAddress(),
            '127.0.0.1'
        );
    }

    /**
     * Test: Getting netmask
     *
     * @covers \Phue\Bridge::getNetmask
     */
    public function testGetNetmask()
    {
        $this->assertEquals(
            $this->bridge->getNetmask(),
            $this->details->netmask
        );
    }

    /**
     * Test: Get gateway
     *
     * @covers \Phue\Bridge::getGateway
     */
    public function testGetGateway()
    {
        $this->assertEquals(
            $this->bridge->getGateway(),
            $this->details->gateway
        );
    }

    /**
     * Test: Get proxy address
     *
     * @covers \Phue\Bridge::getProxyAddress
     */
    public function testGetProxyAddress()
    {
        $this->assertEquals(
            $this->bridge->getProxyAddress(),
            $this->details->proxyaddress
        );
    }

    /**
     * Test: Get proxy port
     *
     * @covers \Phue\Bridge::getProxyPort
     */
    public function testGetProxyPort()
    {
        $this->assertEquals(
            $this->bridge->getProxyPort(),
            $this->details->proxyport
        );
    }

    /**
     * Test: Getting date
     *
     * @covers \Phue\Bridge::getUtcDate
     */
    public function testGetUtcDate()
    {
        $this->assertEquals(
            $this->bridge->getUtcDate(),
            $this->details->UTC
        );
    }

    /**
     * Test: Getting software version
     *
     * @covers \Phue\Bridge::getSoftwareVersion
     */
    public function testGetSoftwareVersion()
    {
        $this->assertEquals(
            $this->bridge->getSoftwareVersion(),
            $this->details->swversion
        );
    }

    /**
     * Test: Is Link Button On?
     *
     * @covers \Phue\Bridge::isLinkButtonOn
     */
    public function testIsLinkButtonOn()
    {
        $this->assertTrue($this->bridge->isLinkButtonOn());
    }

    /**
     * Test: Are portal services enabled?
     *
     * @covers \Phue\Bridge::arePortalServicesEnabled
     */
    public function testArePortalServicesEnabled()
    {
        $this->assertFalse($this->bridge->arePortalServicesEnabled());
    }
}
