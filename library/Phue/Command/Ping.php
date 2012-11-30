<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Transport\Http,
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
     * @return void
     */
    public function send(Client $client)
    {
        $client->getTransport()->sendRequest('none/config');
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
