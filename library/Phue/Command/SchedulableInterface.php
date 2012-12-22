<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue\Command;

use Phue\Client;

/**
 * Schedulable Interface
 *
 * @category Phue
 * @package  Phue
 */
interface SchedulableInterface
{
    /**
     * Get schedulable request params
     *
     * @param Client $client Phue client
     *
     * @return array Key/value array of request params
     */
    public function getSchedulableParams(Client $client);
}
