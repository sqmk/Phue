<?php

namespace Phue\Transport;

/**
 * Transport Interface
 */
interface TransportInterface
{
    /**
     * Send request
     *
     * @param string $path   API path
     * @param string $method Method type
     * @param string $data   Request data
     *
     * @return void
     */
    public function sendRequest($path, $method, \stdClass $data = null);
}
