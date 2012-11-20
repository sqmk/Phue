<?php

namespace Phue\Transport;

use Phue\Command\CommandInterface;

/**
 * Transport Interface
 */
interface TransportInterface
{
    /**
     * Send request by command
     *
     * @param CommandInterface $command Phue command
     *
     * @return void
     */
    public function sendRequestByCommand(CommandInterface $command);
}
