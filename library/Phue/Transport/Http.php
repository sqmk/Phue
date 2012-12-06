<?php

namespace Phue\Transport;

use Phue\Client;
use Phue\Command\CommandInterface;
use Phue\Transport\TransportInterface;
use Phue\Transport\Exception\BridgeException;
use Phue\Transport\Exception\AuthorizationException;
use Phue\Transport\Exception\ConnectionException;

/**
 * Http transport
 */
class Http implements TransportInterface
{
    const METHOD_GET  = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT  = 'PUT';

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
        $this->client = $client;
    }

    /**
     * Open connection
     *
     * @return void
     */
    protected function open()
    {
        // Don't continue if connection already set
        if ($this->connection !== null) {
            return;
        }

        $this->connection = curl_init();
    }

    /**
     * Send request
     *
     * @param string   $path   API path
     * @param string   $method Request method
     * @param stdClass $data   Post data
     *
     * @return void
     */
    public function sendRequest($path, $method = self::METHOD_GET, \stdClass $data = null)
    {
        // Build base URL
        $url = 'http://' . $this->client->getHost() . '/api/';

        // Add path to base URL
        $url .= $path;

        // Initialize connection
        $this->open();

        // Set connection options
        curl_setopt($this->connection, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->connection, CURLOPT_URL, $url);
        curl_setopt($this->connection, CURLOPT_HEADER, false);
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($this->connection, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Get results and status
        $results     = curl_exec($this->connection);
        $status      = curl_getinfo($this->connection, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($this->connection, CURLINFO_CONTENT_TYPE);

        // Close connection
        $this->close();

        // Throw connection exception if status code isn't 200
        if ($status != 200 && $contentType != 'application/json') {
            throw new ConnectionException("Connection failure");
        }

        // Parse results into json
        $jsonResults = json_decode($results);

        // Get first element in array if it's an array response
        if (is_array($jsonResults)) {
            $jsonResults = $jsonResults[0];
        }

        // Get success object only if available
        if (isset($jsonResults->success)) {
            $jsonResults = $jsonResults->success;
        }

        // Throw bridge exception if error is returned in json
        if (isset($jsonResults->error)) {
            switch ($jsonResults->error->type) {
                // Unauthenticated error
                case 1:
                    throw new AuthorizationException(
                        $jsonResults->error->description,
                        $jsonResults->error->type
                    );
                    break;

                // Other errors
                default:
                    throw new BridgeException(
                        $jsonResults->error->description,
                        $jsonResults->error->type
                    );
                    break;
            }
        }

        return $jsonResults;
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

        $this->connection = null;
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
