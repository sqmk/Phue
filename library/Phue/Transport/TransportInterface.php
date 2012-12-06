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
    const METHOD_PUT  = 'PUT';

    /**
     * Send request
     *
     * @param string $path   API path
     * @param string $method Method type
     * @param string $data   Request data
     *
     * @return void
     */
    public function sendRequest($path, $method = self::METHOD_GET, \stdClass $data = null);
}
