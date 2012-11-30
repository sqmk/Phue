<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Transport\Http,
    Phue\Command\CommandInterface;

/**
 * Authenticate command
 */
class IsAuthorized implements CommandInterface
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
        try {
            $client->getTransport()->sendRequest(
                $client->getUsername()
            );
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }
}
