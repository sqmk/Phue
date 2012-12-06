<?php

namespace Phue\Command;

use Phue\Client;
use Phue\Transport\Http;
use Phue\Command\CommandInterface;

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
     * @return bool True if authorized, false if not
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
