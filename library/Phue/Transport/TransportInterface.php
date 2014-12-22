<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Transport;

/**
 * Transport Interface
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
     * @param string    $path    API path
     * @param string    $method  Request method
     * @param \stdClass $data    Body data
     *
     * @return mixed Command result
     */
    public function sendRequest($path, $method = self::METHOD_GET, \stdClass $data = null);
}
