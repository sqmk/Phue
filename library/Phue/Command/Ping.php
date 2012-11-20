<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Command\CommandInterface;

/**
 * Ping command
 */
class Ping implements CommandInterface
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
        $client->getTransport()->sendRequest(
            'GET',
            '',
            $this->buildRequestData($client)
        );
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
