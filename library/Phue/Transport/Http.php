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

use Phue\Client;
use Phue\Command\CommandInterface;
use Phue\Transport\TransportInterface;
use Phue\Transport\Exception\ConnectionException;

/**
 * Http transport
 *
 * @category Phue
 * @package  Phue
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
     * Exception map
     *
     * @var array
     */
    protected static $exceptionMap = [
        0   => 'Phue\Transport\Exception\BridgeException',
        1   => 'Phue\Transport\Exception\AuthorizationException',
        2   => 'Phue\Transport\Exception\InvalidBodyException',
        3   => 'Phue\Transport\Exception\ResourceException',
        4   => 'Phue\Transport\Exception\MethodException',
        5   => 'Phue\Transport\Exception\InvalidParameterException',
        6   => 'Phue\Transport\Exception\ParameterUnavailableException',
        7   => 'Phue\Transport\Exception\InvalidValueException',
        101 => 'Phue\Transport\Exception\LinkButtonException',
        301 => 'Phue\Transport\Exception\GroupTableFullException',
        901 => 'Phue\Transport\Exception\ThrottleException',
    ];

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
        // Build request url
        $url = "http://{$this->client->getHost()}/api/{$path}";

        // Initialize connection
        $curl = curl_init();

        // Set connection options
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Get results and status
        $results     = curl_exec($curl);
        $status      = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        // Close connection
        curl_close($curl);

        // Throw connection exception if status code isn't 200
        if ($status != 200 && $contentType != 'application/json') {
            throw new ConnectionException("Connection failure");
        }

        // Parse json results
        $jsonResults = json_decode($results);

        // Get first element in array if it's an array response
        if (is_array($jsonResults)) {
            $jsonResults = $jsonResults[0];
        }

        // Get success object only if available
        if (isset($jsonResults->success)) {
            $jsonResults = $jsonResults->success;
        }

        // Get error type
        if (isset($jsonResults->error)) {
            $this->throwExceptionByType(
                $jsonResults->error->type,
                $jsonResults->error->description
            );
        }

        return $jsonResults;
    }

    /**
     * Throw exception by type
     *
     * @param string $type        Error type
     * @param string $description Description of error
     *
     * @return void
     */
    public function throwExceptionByType($type, $description)
    {
        // Determine exception
        $exceptionClass = isset(static::$exceptionMap[$type])
                        ? static::$exceptionMap[$type]
                        : static::$exceptionMap[0];

        throw new $exceptionClass($description, $type);
    }
}
