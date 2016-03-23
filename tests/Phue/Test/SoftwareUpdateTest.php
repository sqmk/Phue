<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */
namespace Phue\Test;

use Phue\Client;
use Phue\SoftwareUpdate;

/**
 * Tests for Phue\SoftwareUpdate
 */
class SoftwareUpdateTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Set up
     *
     * @covers \Phue\SoftwareUpdate::__construct
     */
    public function setUp()
    {
        // Mock client
        $this->mockClient = $this->getMock('\Phue\Client', 
            array(
                'sendCommand'
            ), array(
                '127.0.0.1'
            ));
        
        // Build stub attributes
        $this->attributes = (object) array(
            'updatestate' => 2,
            'checkforupdate' => false,
            'devicetypes' => (object) array(
                'bridge' => true,
                'lights' => array(
                    '1',
                    '2',
                    '3'
                )
            ),
            'url' => '',
            'text' => '010000000',
            'notify' => false
        );
        
        // Create software update object
        $this->softwareUpdate = new SoftwareUpdate($this->attributes, 
            $this->mockClient);
    }

    /**
     * Test: Get update state
     *
     * @covers \Phue\SoftwareUpdate::getUpdateState
     */
    public function testGetUpdateState()
    {
        $this->assertEquals($this->attributes->updatestate, 
            $this->softwareUpdate->getUpdateState());
    }

    /**
     * Test: Installing updates
     *
     * @covers \Phue\SoftwareUpdate::installUpdates
     */
    public function testInstallUpdates()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetBridgeConfig'));
        
        // Ensure installUpdates returns self
        $this->assertEquals($this->softwareUpdate, 
            $this->softwareUpdate->installUpdates());
        
        // Ensure new value can be retrieved by getUpdateState
        $this->assertEquals(3, $this->softwareUpdate->getUpdateState());
    }

    /**
     * Test: Checking for update?
     *
     * @covers \Phue\SoftwareUpdate::checkingForUpdate
     */
    public function testCheckingForUpdate()
    {
        $this->assertEquals($this->attributes->checkforupdate, 
            $this->softwareUpdate->checkingForUpdate());
    }

    /**
     * Test: Check for update
     *
     * @covers \Phue\SoftwareUpdate::checkForUpdate
     */
    public function testCheckForUpdate()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetBridgeConfig'));
        
        // Ensure checkForUpdate returns self
        $this->assertEquals($this->softwareUpdate, 
            $this->softwareUpdate->checkForUpdate());
        
        // Ensure new value can be retrieved by checkingForUpdate
        $this->assertEquals(true, $this->softwareUpdate->checkingForUpdate());
    }

    /**
     * Test: Is bridge updatable?
     *
     * @covers \Phue\SoftwareUpdate::isBridgeUpdatable
     */
    public function testIsBridgeUpdatable()
    {
        $this->assertEquals($this->attributes->devicetypes->bridge, 
            $this->softwareUpdate->isBridgeUpdatable());
    }

    /**
     * Test: Get updatable lights
     *
     * @covers \Phue\SoftwareUpdate::getUpdatableLights
     */
    public function testGetUpdatableLights()
    {
        $this->assertEquals($this->attributes->devicetypes->lights, 
            $this->softwareUpdate->getUpdatableLights());
    }

    /**
     * Test: Get release notes URL
     *
     * @covers \Phue\SoftwareUpdate::getReleaseNotesUrl
     */
    public function testGetReleaseNotesUrl()
    {
        $this->assertEquals($this->attributes->url, 
            $this->softwareUpdate->getReleaseNotesUrl());
    }

    /**
     * Test: Get release notes brief
     *
     * @covers \Phue\SoftwareUpdate::getReleaseNotesBrief
     */
    public function testGetReleaseNotesBrief()
    {
        $this->assertEquals($this->attributes->text, 
            $this->softwareUpdate->getReleaseNotesBrief());
    }

    /**
     * Test: Is install notification enabled?
     *
     * @covers \Phue\SoftwareUpdate::isInstallNotificationEnabled
     */
    public function testIsInstallNotificationEnabled()
    {
        $this->assertEquals($this->attributes->notify, 
            $this->softwareUpdate->isInstallNotificationEnabled());
    }

    /**
     * Test: Disable install notification
     *
     * @covers \Phue\SoftwareUpdate::disableInstallNotification
     */
    public function testDisableInstallNotification()
    {
        // Expect client's sendCommand usage
        $this->mockClient->expects($this->once())
            ->method('sendCommand')
            ->with($this->isInstanceOf('\Phue\Command\SetBridgeConfig'));
        
        // Ensure disableInstallNotification returns self
        $this->assertEquals($this->softwareUpdate, 
            $this->softwareUpdate->disableInstallNotification());
        
        // Ensure new value can be retrieved by isInstallNotificationEnabled
        $this->assertEquals(false, 
            $this->softwareUpdate->isInstallNotificationEnabled());
    }
}
