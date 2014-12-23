<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue;

use Phue\Command\SetBridgeConfig;

/**
 * Software Update object
 */
class SoftwareUpdate
{
    /**
     * State: No update
     */
    const STATE_NO_UPDATE = 0;

    /**
     * State: Downloading
     */
    const STATE_DOWNLOADING = 1;

    /**
     * State: Ready to install
     */
    const STATE_READY_TO_INSTALL = 2;

    /**
     * State: Installing
     */
    const STATE_INSTALLING = 3;

    /**
     * Sofware Update attributes
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
     * Construct a Phue SoftwareUpdate object
     *
     * @param \stdClass $attributes SoftwareUpdate attributes
     * @param Client    $client     Phue client
     */
    public function __construct(\stdClass $attributes, Client $client)
    {
        $this->attributes = $attributes;
        $this->client     = $client;
    }

    /**
     * Get update state
     *
     * @return int Update state
     */
    public function getUpdateState()
    {
        return $this->attributes->updatestate;
    }

    /**
     * Install updates
     *
     * @return self This object
     */
    public function installUpdates()
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                [
                    'swupdate' => [
                        'updatestate' => self::STATE_INSTALLING
                    ]
                ]
            )
        );

        $this->attributes->updatestate = self::STATE_INSTALLING;

        return $this;
    }

    /**
     * Checking for update?
     *
     * @return bool True if checking, false if not
     */
    public function checkingForUpdate()
    {
        return $this->attributes->checkforupdate;
    }

    /**
     * Check for update
     *
     * @param bool $state True to check for update, false if not
     *
     * @return self This object
     */
    public function checkForUpdate()
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                [
                    'swupdate' => [
                        'checkforupdate' => true
                    ]
                ]
            )
        );

        $this->attributes->checkforupdate = true;

        return $this;
    }

    /**
     * Is bridge updatable?
     *
     * @return bool True if updatable, false if not
     */
    public function isBridgeUpdatable()
    {
        return (bool) $this->attributes->devicetypes->bridge;
    }

    /**
     * Get updatable lights
     *
     * @return array List of updatable light ids
     */
    public function getUpdatableLights()
    {
        return (array) $this->attributes->devicetypes->lights;
    }

    /**
     * Get release notes URL
     *
     * @return string Release notes URL
     */
    public function getReleaseNotesUrl()
    {
        return $this->attributes->url;
    }

    /**
     * Get release notes brief
     *
     * @return string Release notes
     */
    public function getReleaseNotesBrief()
    {
        return $this->attributes->text;
    }

    /**
     * Is the install notification enabled?
     *
     * @return bool True if completed, false if not
     */
    public function isInstallNotificationEnabled()
    {
        return (bool) $this->attributes->notify;
    }

    /**
     * Disable the install notification
     *
     * @return self This object
     */
    public function disableInstallNotification()
    {
        $this->client->sendCommand(
            new SetBridgeConfig(
                [
                    'swupdate' => [
                        'notify' => false
                    ]
                ]
            )
        );

        $this->attributes->notify = false;

        return $this;
    }
}
