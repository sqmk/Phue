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
 * Scene object
 */
class Scene
{
    /**
     * Id
     *
     * @var int
     */
    protected $id;

    /**
     * Scene attributes
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
     * Construct a Phue Scene object
     *
     * @param string    $id         Id
     * @param \stdClass $attributes Scene attributes
     * @param Client    $client     Phue client
     */
    public function __construct($id, \stdClass $attributes, Client $client)
    {
        $this->id         = $id;
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get scene Id
     *
     * @return int Scene id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get assigned name of scene
     *
     * @return string Name of scene
     */
    public function getName()
    {
        return $this->attributes->name;
    }

    /**
     * Get light ids
     *
     * @return array List of light ids
     */
    public function getLightIds()
    {
        return $this->attributes->lights;
    }

    /**
     * Is active
     *
     * @return bool True if active, false if not
     */
    public function isActive()
    {
        return (bool) $this->attributes->active;
    }

    /**
     * __toString
     *
     * @return string Scene Id
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
