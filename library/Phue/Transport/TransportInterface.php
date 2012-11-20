<?php

namespace Phue\Transport;

use Phue\Command\CommandInterface;

/**
 * Transport Interface
 */
interface TransportInterface
{
    /**
     * Send request
     *
     * @param string $method Method type
     * @param string $path   API path
     * @param string $data   Request data
     *
     * @return void
     */
    public function sendRequest($method, $path, \stdClass $data = null);
}
