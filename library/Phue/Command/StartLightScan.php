<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Transport\Http,
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
            "{$client->getUsername()}/lights",
            Http::METHOD_POST
        );

        return $response;
    }
}
