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

use Phue\Transport\Adapter\AdapterInterface;

/**
 * Curl Http adapter
 *
 * @category Phue
 * @package  Phue
 */
class Curl implements AdapterInterface
{
    /**
     * Curl resource
     *
     * @var resource
     */
    protected $curl;

    /**
     * Constructs a curl adapter
     *
     * @return void
     */
    public function __construct()
    {
        // Throw exception if curl extension is not loaded
        if (!extension_loaded('curl')) {
            throw new \BadFunctionCallException('The cURL extension is required.');
        }
    }

    /**
     * Opens the connection
     *
     * @return void
     */
    public function open()
    {
        $this->curl = curl_init();
    }

    /**
     * Sends request
     *
     * @param string    $address Request path
     * @param string    $method  Request method
     * @param \stdClass $data    Body data
     *
     * @return string Result
     */
    public function send($address, $method, $body = null)
    {
        // Set connection options
        curl_setopt($this->curl, CURLOPT_URL, $address);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->curl, CURLOPT_HEADER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        if (strlen($body)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        }

        return curl_exec($this->curl);
    }

    /**
     * Get response http status code
     *
     * @return string Response http code
     */
    public function getHttpStatusCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * Get response content type
     *
     * @return string Response content type
     */
    public function getContentType()
    {
        return curl_getinfo($this->curl, CURLINFO_CONTENT_TYPE);
    }

    /**
     * Closes the curl connection
     *
     * @return void
     */
    public function close()
    {
        curl_close($this->curl);
        unset($this->curl);
    }
}
