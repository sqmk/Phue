<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace PhueTest\Transport\Adapter;

use Phue\Transport\Adapter\Streaming as StreamingAdapter;

/**
 * Tests for Phue\Transport\Adapter\Streaming
 *
 * @category Phue
 * @package  Phue
 */
class StreamingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    public function setUp()
    {
        $this->streamingAdapter = new StreamingAdapter;
    }

    /**
     * Test: Open streaming adapter
     *
     * @covers Phue\Transport\Adapter\Streaming::open
     */
    public function testOpen()
    {
        $this->streamingAdapter->open();
    }

    /**
     * Test: Close streaming adapter
     *
     * @covers Phue\Transport\Adapter\Streaming::close
     */
    public function testClose()
    {
        $this->streamingAdapter->open();
        $this->streamingAdapter->send(false, 'GET', 'dummy');
        $this->streamingAdapter->close();

        $this->assertAttributeEmpty(
            'streamContext',
            $this->streamingAdapter
        );

        $this->assertAttributeEmpty(
            'fileStream',
            $this->streamingAdapter
        );
    }

    /**
     * Test: Send nowhere
     *
     * @covers Phue\Transport\Adapter\Streaming::send
     */
    public function testSend()
    {
        $this->streamingAdapter->open();

        $this->assertFalse(
            $this->streamingAdapter->send(false, 'GET', 'dummy')
        );

        $this->streamingAdapter->close();
    }

    /**
     * Test: Get Http Status Code
     *
     * @covers Phue\Transport\Adapter\Streaming::getHttpStatusCode
     */
    public function testGetHttpStatusCode()
    {
        $this->streamingAdapter->open();

        $this->assertEmpty(
            $this->streamingAdapter->getHttpStatusCode()
        );

        $this->streamingAdapter->close();
    }

    /**
     * Test: Get Content Type
     *
     * @covers Phue\Transport\Adapter\Streaming::getContentType
     */
    public function testGetContentType()
    {
        $this->streamingAdapter->open();

        $this->assertEmpty(
            $this->streamingAdapter->getContentType()
        );

        $this->streamingAdapter->close();
    }

    /**
     * Test: Get headers
     *
     * @covers Phue\Transport\Adapter\Streaming::getHeaders
     */
    public function testGetHeaders()
    {
        $this->streamingAdapter->getHeaders();
    }
}
