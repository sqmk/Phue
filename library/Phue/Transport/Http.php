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
use Phue\Transport\Adapter\AdapterInterface;
use Phue\Transport\Adapter\Curl as DefaultAdapter;

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
    protected $client;

    /**
     * Adapter
     *
     * @var AdapterInterface
     */
    protected $adapter;

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
     * Get adapter for transport
     *
     * Auto created adapter if one is not present
     *
     * @return AdapterInterface Adapter
     */
    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->setAdapter(new DefaultAdapter);
        }

        return $this->adapter;
    }

    /**
     * Set adapter
     *
     * @param AdapterInterface $adapter Transport adapter
     *
     * @return Http Self object
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Send request
     *
     * @param string   $address API address
     * @param string   $method  Request method
     * @param stdClass $body    Post body
     *
     * @return string Request response
     */
    public function sendRequest($address, $method = self::METHOD_GET, \stdClass $body = null)
    {
        // Build request url
        $url = $this->buildRequestUrl($address, true);

        // Open connection
        $this->getAdapter()->open();

        // Send and get response
        $results     = $this->getAdapter()->send($url, $method, $body ? json_encode($body) : null);
        $status      = $this->getAdapter()->getHttpStatusCode();
        $contentType = $this->getAdapter()->getContentType();        

        // Close connection
        $this->getAdapter()->close();

        // Throw connection exception if status code isn't 200 or wrong content type
        if ($status != 200 || $contentType != 'application/json') {
            throw new ConnectionException('Connection failure');
        }

        // Parse json results
        $jsonResults = json_decode($results);

        // Get first element in array if it's an array response
        if (is_array($jsonResults)) {
            $jsonResults = $jsonResults[0];
        }

        // Get error type
        if (isset($jsonResults->error)) {
            throw $this->getExceptionByType(
                $jsonResults->error->type,
                $jsonResults->error->description
            );
        }

        // Get success object only if available
        if (isset($jsonResults->success)) {
            $jsonResults = $jsonResults->success;
        }

        return $jsonResults;
    }

    /**
     * Build request URL
     *
     * @param string $path        Request path
     * @param bool   $includeHost Include host in path
     *
     * @return string Request URL
     */
    public function buildRequestUrl($path, $includeHost = false)
    {
        // Start with full path
        $fullPath = "/api/{$path}";

        // Include host if necessary
        if ($includeHost) {
            $fullPath = "http://{$this->client->getHost()}" . $fullPath;
        }

        return $fullPath;
    }

    /**
     * Get exception by type
     *
     * @param string $type        Error type
     * @param string $description Description of error
     *
     * @return Exception Built exception
     */
    public function getExceptionByType($type, $description)
    {
        // Determine exception
        $exceptionClass = isset(static::$exceptionMap[$type])
                        ? static::$exceptionMap[$type]
                        : static::$exceptionMap[0];

        return new $exceptionClass($description, $type);
    }
}
