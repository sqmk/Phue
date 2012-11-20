<?php

namespace Phue\Transport;

use Phue\Client,
    Phue\Command\CommandInterface,
    Phue\Transport\TransportInterface;

/**
 * Http transport
 */
class Http implements TransportInterface
{
    /**
     * Phue Client
     *
     * @var Client
     */
    protected $client = null;

    /**
     * Curl connection
     *
     * @var resource Curl resource
     */
    protected $connection = null;

    /**
     * Construct Http transport
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = null;
    }

    /**
     * Open connection
     *
     * @return void
     */
    protected function open()
    {
        // Don't continue if client already set
        if ($this->client !== null) {
            return;
        }

        $this->client = curl_init
    }

    /**
     * Send request by command
     *
     * @param CommandInterface $command
     *
     * @return void
     */
    public function sendRequestByCommand(CommandInterface $command)
    {
        // Build base URL
        $url = 'http://' . $this->client->getHost() . '/api/';

        // Add username if one
        if ($this->client->getUsername()) {
            $url .= $this->client->getUsername() . '/';
        }

        // Initialize connection
        $this->open();

        // Set connection options
        curl_setopt($this->connection, CURLOPT_URL, $url);
        curl_setopt($this->connection, CURLOPT_HEADER, false);
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);

        // Get response results
        $results = curl_exec($this->connection);

        // Close connection
        $this->close();

        var_dump($results);
    }

    /**
     * Close connection
     *
     * @return void
     */
    protected function close()
    {
        // Don't continue if no connection
        if ($this->connection === null) {
            return;
        }

        curl_close($this->connection);
    }

    /**
     * Destruct Http transport
     *
     * @return void
     */
    public function __destruct()
    {   
        $this->close();
    }
}
