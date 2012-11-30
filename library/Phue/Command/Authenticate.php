<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Transport\Http,
    Phue\Command\CommandInterface;

/**
 * Authenticate command
 */
class Authenticate implements CommandInterface
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
            '',
            Http::METHOD_POST,
            $this->buildRequestData($client)
        );

        return $response;
    }

    /**
     * Build request data
     *
     * @param Client $client Phue client
     *
     * @return stdClass Request data object
     */
    protected function buildRequestData(Client $client)
    {
        return (object) [
            'username'   => $client->getUsername(),
            'devicetype' => $client::CLIENT_NAME
        ];
    }
}
