<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Transport;

use Phue\Client;
use Phue\Command\CommandInterface;
use Phue\Transport\Exception\ConnectionException;
use Phue\Transport\Adapter\AdapterInterface;
use Phue\Transport\Adapter\Curl as DefaultAdapter;

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
    public static $exceptionMap = [
        0   => 'Phue\Transport\Exception\BridgeException',
        1   => 'Phue\Transport\Exception\UnauthorizedUserException',
        2   => 'Phue\Transport\Exception\InvalidJsonBodyException',
        3   => 'Phue\Transport\Exception\ResourceUnavailableException',
        4   => 'Phue\Transport\Exception\MethodUnavailableException',
        5   => 'Phue\Transport\Exception\MissingParameterException',
        6   => 'Phue\Transport\Exception\ParameterUnavailableException',
        7   => 'Phue\Transport\Exception\InvalidValueException',
        8   => 'Phue\Transport\Exception\ParameterUnmodifiableException',
        11  => 'Phue\Transport\Exception\TooManyItemsInListException',
        12  => 'Phue\Transport\Exception\PortalConnectionRequiredException',
        101 => 'Phue\Transport\Exception\LinkButtonException',
        110 => 'Phue\Transport\Exception\DisablingDhcpProhibitedException',
        111 => 'Phue\Transport\Exception\InvalidUpdateStateException',
        201 => 'Phue\Transport\Exception\DeviceParameterUnmodifiableException',
        301 => 'Phue\Transport\Exception\GroupTableFullException',
        302 => 'Phue\Transport\Exception\LightGroupTableFullException',
        304 => 'Phue\Transport\Exception\DeviceUnreachableException',
        305 => 'Phue\Transport\Exception\GroupUnmodifiableException',
        401 => 'Phue\Transport\Exception\SceneCreationInProgressException',
        402 => 'Phue\Transport\Exception\SceneBufferFullException',
        501 => 'Phue\Transport\Exception\SensorCreationProhibitedException',
        502 => 'Phue\Transport\Exception\SensorListFullException',
        601 => 'Phue\Transport\Exception\RuleListFullException',
        607 => 'Phue\Transport\Exception\RuleConditionException',
        608 => 'Phue\Transport\Exception\RuleActionException',
        609 => 'Phue\Transport\Exception\RuleActivationException',
        701 => 'Phue\Transport\Exception\ScheduleListFullException',
        702 => 'Phue\Transport\Exception\InvalidScheduleTimeZoneException',
        703 => 'Phue\Transport\Exception\ScheduleTimeUpdateException',
        704 => 'Phue\Transport\Exception\InvalidScheduleTagException',
        705 => 'Phue\Transport\Exception\ScheduleTimeInPastException',
        901 => 'Phue\Transport\Exception\InternalErrorException',
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
     * @return self This object
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get exception by type
     *
     * @param string $type        Error type
     * @param string $description Description of error
     *
     * @return \Exception Built exception
     */
    public function getExceptionByType($type, $description)
    {
        // Determine exception
        $exceptionClass = isset(static::$exceptionMap[$type])
                        ? static::$exceptionMap[$type]
                        : static::$exceptionMap[0];

        return new $exceptionClass($description, $type);
    }

    /**
     * Send request
     *
     * @param string    $address API address
     * @param string    $method  Request method
     * @param \stdClass $body    Post body
     *
     * @throws ConnectionException
     * @throws \Exception
     *
     * @return string Request response
     */
    public function sendRequest($address, $method = self::METHOD_GET, \stdClass $body = null)
    {
        $jsonResults = $this->getJsonResponse($address, $method, $body);

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
     * Send request, bypass body validation
     *
     * @param string    $address API address
     * @param string    $method  Request method
     * @param \stdClass $body    Post body
     *
     * @throws ConnectionException
     * @throws \Exception
     *
     * @return string Request response
     */
    public function sendRequestBypassBodyValidation($address, $method = self::METHOD_GET, \stdClass $body = null)
    {
        return $this->getJsonResponse($address, $method, $body);
    }

    /**
     * Send request
     *
     * @param string    $address API address
     * @param string    $method  Request method
     * @param \stdClass $body    Post body
     *
     * @return \stdClass Json body
     */
    protected function getJsonResponse($address, $method = self::METHOD_GET, \stdClass $body = null)
    {
        // Build request url
        $url = "http://{$this->client->getHost()}{$address}";

        // Open connection
        $this->getAdapter()->open();

        // Send and get response
        $results     = $this->getAdapter()->send($url, $method, $body ? json_encode($body) : null);
        $status      = $this->getAdapter()->getHttpStatusCode();
        $contentType = $this->getAdapter()->getContentType();

        // Throw connection exception if status code isn't 200 or wrong content type
        if ($status != 200 || $contentType != 'application/json') {
            throw new ConnectionException('Connection failure');
        }

        // Parse json results
        $jsonResults = json_decode($results);

        return $jsonResults;
    }
}
