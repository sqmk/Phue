<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

/**
 * Portal object
 */
class Portal
{
    /**
     * Portal attributes
     *
     * @var \stdClass
     */
    protected $attributes;

    /**
     * Phue client
     *
     * @var Client
     */
    protected $client;

    /**
     * Construct a Phue Portal object
     *
     * @param \stdClass $attributes Portal attributes
     * @param Client    $client     Phue client
     */
    public function __construct(\stdClass $attributes, Client $client)
    {
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Is signed on?
     *
     * @return bool True if signed on, false if not
     */
    public function isSignedOn()
    {
        return $this->attributes->signedon;
    }

    /**
     * Is incoming
     *
     * @return bool True if incoming data, false if not
     */
    public function isIncoming()
    {
        return $this->attributes->incoming;
    }

    /**
     * Is outgoing
     *
     * @return bool True if outgoing data, false if not
     */
    public function isOutgoing()
    {
        return $this->attributes->outgoing;
    }

    /**
     * Get communication
     *
     * @return string Communication status
     */
    public function getCommunication()
    {
        return $this->attributes->communication;
    }
}
