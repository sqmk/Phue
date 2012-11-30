<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Command\CommandInterface;

/**
 * Start Light Scan command
 */
class StartLightScan implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return mixed
     */
    public function send(Client $client)
    {
        // Get response
        $response = $client->getTransport()->sendRequest(
            'POST',
            "{$client->getUsername()}/lights"
        );

        return $response;
    }
}
