<?php

namespace Phue\Command;

use Phue\Client;
use Phue\Command;

/**
 * Command Interface
 */
interface CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return mixed
     */
    public function send(Client $client);
}
