<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 * @package   Phue
 */

namespace Phue;

use Phue\Transport\Http;
use Phue\Transport\TransportInterface;
use Phue\Command\CommandInterface;

/**
 * Client for connecting to Philips Hue bridge
 *
 * @category Phue
 * @package  Phue
 */
class Client
{
    /**
     * Client name
     */
    const CLIENT_NAME = 'Phue';

    /**
     * Host address
     *
     * @var string
     */
    protected $host = null;

    /**
     * Username
     *
     * @var string
     */
    protected $username = null;

    /**
     * Transport
     *
     * @var TransportInterface
     */
    protected $transport = null;

    /**
     * Construct a Phue Client
     *
     * @param string $host     Host address
     * @param string $username Username
     */
    public function __construct($host, $username = null)
    {
        $this->setHost($host);
        $this->setUsername($username);
    }

    /**
     * Get host
     *
     * @return string Host address
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set host
     *
     * @return void
     */
    public function setHost($host)
    {
        $this->host = (string) $host;
    }

    /**
     * Get username
     *
     * @return string Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username Username
     *
     * @return void
     */
    public function setUsername($username)
    {
        // Hash username if not already in hash format
        if (!preg_match('/[a-f0-9]{32}/i', $username)) {
            $username = md5($username);
        }

        $this->username = (string) $username;
    }

    /**
     * Get transport
     *
     * @return TransportInterface
     */
    public function getTransport()
    {
        // Set transport if haven't
        if ($this->transport === null) {
            $this->transport = new Http($this);
        }

        return $this->transport;
    }

    /**
     * Set transport
     *
     * @param TransportInterface $transport Transport
     *
     * @return void
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Send command to server
     *
     * @param Command $command Phue command
     *
     * @return void
     */
    public function sendCommand(CommandInterface $command)
    {
        // Send command
        return $command->send($this);
    }
}
