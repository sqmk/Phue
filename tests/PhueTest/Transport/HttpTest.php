<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest\Transport;

use Phue\Transport\Http;

/**
 * Tests for Phue\Transport\Http
 *
 * @category Phue
 * @package  Phue
 */
class HttpTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock(
            '\Phue\Client',
            ['getTransport'],
            ['127.0.0.1']
        );

        // Set transport
        $this->transport = new Http($this->mockClient);
    }

    /**
     * Test: Throw exception by type
     *
     * @dataProvider providerErrorTypes
     *
     * @covers Phue\Transport\Http::throwExceptionByType
     */
    public function testThrowExceptionByType($type, $description, $exceptionName)
    {
        $this->setExpectedException($exceptionName, $description, $type);

        $this->transport->throwExceptionByType($type, $description);
    }

    /**
     * Provider: Error types
     *
     * @return array
     */
    public function providerErrorTypes()
    {
        return [
            [1,   'Authorization',         'Phue\Transport\Exception\AuthorizationException'],
            [2,   'Invalid Body',          'Phue\Transport\Exception\InvalidBodyException'],
            [3,   'Resource',              'Phue\Transport\Exception\ResourceException'],
            [4,   'Method',                'Phue\Transport\Exception\MethodException'],
            [5,   'Invalid Parameter',     'Phue\Transport\Exception\InvalidParameterException'],
            [6,   'Parameter Unavailable', 'Phue\Transport\Exception\ParameterUnavailableException'],
            [7,   'Invalid Value',         'Phue\Transport\Exception\InvalidValueException'],
            [101, 'Link Button',           'Phue\Transport\Exception\LinkButtonException'],
            [301, 'Group Table Full',      'Phue\Transport\Exception\GroupTableFullException'],
            [901, 'Throttle',              'Phue\Transport\Exception\ThrottleException'],
            [-1,  'Unknown',               'Phue\Transport\Exception\BridgeException'],
        ];
    }
}
