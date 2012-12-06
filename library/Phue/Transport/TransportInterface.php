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
     * Send request
     *
     * @param string $path   API path
     * @param string $method Method type
     * @param string $data   Request data
     *
     * @return void
     */
    public function sendRequest($path, $method, \stdClass $data = null);
}
