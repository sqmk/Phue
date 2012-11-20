<?php

namespace Phue\Command;

use Phue\Client,
    Phue\Command\CommandInterface;

/**
 * Authenticate command
 */
class Authenticate implements CommandInterface
{
    public function getMethod()
    {
        return 'POST';
    }

    public function getPath()
    {
        return 'api/'
    }
}
