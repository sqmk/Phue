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
     * @param string $address API path
     * @param string $method Request method
     * @param \stdClass $body Body data
     *
     * @return mixed Command result
     */
    public function sendRequest($address, $method = self::METHOD_GET, \stdClass $body = null);

    /**
     * Send request, bypass body validation
     *
     * @param string $address API path
     * @param string $method Request method
     * @param \stdClass $body Body data
     *
     * @return mixed Command result
     */
    public function sendRequestBypassBodyValidation($address, $method = self::METHOD_GET, \stdClass $body = null);
}
