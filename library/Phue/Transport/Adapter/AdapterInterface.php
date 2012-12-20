<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue\Transport\Adapter;

/**
 * Adapter Interface
 *
 * @category Phue
 * @package  Phue
 */
interface AdapterInterface
{
    /**
     * Opens the connection
     *
     * @return void
     */
    public function open();

    /**
     * Sends request
     *
     * @param string $url    Request URL
     * @param string $method Request method
     * @param string $data   Body data
     *
     * @return string Result
     */
    public function send($url, $method, $body = null);

    /**
     * Get http status code from response
     *
     * @return string Status code
     */
    public function getHttpStatusCode();

    /**
     * Get content type from response
     *
     * @return string Content type
     */
    public function getContentType();

    /**
     * Closes the connection
     *
     * @return void
     */
    public function close();
}
