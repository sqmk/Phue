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
use Phue\Command\GetRules;
use Phue\Transport\TransportInterface;

/**
 * Tests for Phue\Command\GetRules
 */
class GetRulesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        $this->getRules = new GetRules();

        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
// TODO        ['getUsername', 'getTransport'],
//             ['127.0.0.1']
        	array('getUsername', 'getTransport'),
        	array('127.0.0.1')
        );

        // Mock transport
        $this->mockTransport = $this->getMock(
            '\Phue\Transport\TransportInterface',
// TODO        ['sendRequest']
        	array('sendRequest')
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
     * Test: Found no rules
     *
     * @covers \Phue\Command\GetRules::send
     */
    public function testFoundNoRules()
    {
        // Stub transport's sendRequest method
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/rules"))
            ->will($this->returnValue(new \stdClass));

        // Send command and get response
        $response = $this->getRules->send($this->mockClient);

        // Ensure we have an empty array
        $this->assertInternalType('array', $response);
        $this->assertEmpty($response);
    }

    /**
     * Test: Found rules
     *
     * @covers \Phue\Command\GetRules::send
     */
    public function testFoundRules()
    {
        // Mock transport results
// TODO    $mockTransportResults = (object) [
//             1 => new \stdClass,
//             2 => new \stdClass,
//         ];
    	$mockTransportResults = (object) array(
    			1 => new \stdClass,
    			2 => new \stdClass,
    	);

        // Stub transport's sendRequest usage
        $this->mockTransport->expects($this->once())
            ->method('sendRequest')
            ->with($this->equalTo("/api/{$this->mockClient->getUsername()}/rules"))
            ->will($this->returnValue($mockTransportResults));

        // Send command and get response
        $response = $this->getRules->send($this->mockClient);

        // Ensure we have an array of Rules
        $this->assertInternalType('array', $response);
        $this->assertContainsOnlyInstancesOf('\Phue\Rule', $response);
    }
}
