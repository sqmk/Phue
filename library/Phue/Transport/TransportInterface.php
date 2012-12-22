<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue\Transport;

/**
 * Transport Interface
 *
 * @category Phue
 * @package  Phue
 */
interface TransportInterface
{
    /**
     * Get method
     */
    const METHOD_GET = 'GET';

    /**
     * Post method
     */
    const METHOD_POST = 'POST';

    /**
     * Put method
     */
    const METHOD_PUT = 'PUT';

    /**
     * Delete method
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * Send request
     *
     * @param string $address API address
     * @param string $method  Request method
     * @param string $body    Request body
     *
     * @return void
     */
    public function sendRequest($path, $method = self::METHOD_GET, \stdClass $data = null);
}
