<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Test\Transport\Adapter;

use Phue\Transport\Adapter\Curl as CurlAdapter;

/**
 * Tests for Phue\Transport\Adapter\Curl
 */
class CurlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */
    public function setUp()
    {
        try {
            $this->curlAdapter = new CurlAdapter;
        } catch (\BadFunctionCallException $e) {
            $this->markTestSkipped(
                $e->getMessage()
            );
        }
    }

    /**
     * Test: Instantiation without exception
     *
     * @covers Phue\Transport\Adapter\Curl::__construct
     */
    public function testInstantiation()
    {
        $curlAdapter = new CurlAdapter;
    }

    /**
     * Test: Open curl adapter
     *
     * @covers Phue\Transport\Adapter\Curl::open
     */
    public function testOpen()
    {
        $this->curlAdapter->open();

        $this->assertAttributeInternalType(
            'resource',
            'curl',
            $this->curlAdapter
        );
    }

    /**
     * Test: Close curl adapter
     *
     * @covers Phue\Transport\Adapter\Curl::close
     */
    public function testClose()
    {
        $this->curlAdapter->open();
        $this->curlAdapter->close();

        $this->assertAttributeEmpty(
            'curl',
            $this->curlAdapter
        );
    }

    /**
     * Test: Send nowhere
     *
     * @covers Phue\Transport\Adapter\Curl::send
     */
    public function testSend()
    {
        $this->curlAdapter->open();

        $this->assertFalse(
            $this->curlAdapter->send(false, 'GET', 'dummy')
        );

        $this->curlAdapter->close();
    }

    /**
     * Test: Get Http Status Code
     *
     * @covers Phue\Transport\Adapter\Curl::getHttpStatusCode
     */
    public function testGetHttpStatusCode()
    {
        $this->curlAdapter->open();

        $this->assertEmpty(
            $this->curlAdapter->getHttpStatusCode()
        );

        $this->curlAdapter->close();
    }

    /**
     * Test: Get Content Type
     *
     * @covers Phue\Transport\Adapter\Curl::getContentType
     */
    public function testGetContentType()
    {
        $this->curlAdapter->open();

        $this->assertEmpty(
            $this->curlAdapter->getContentType()
        );

        $this->curlAdapter->close();
    }
}
