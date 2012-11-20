<?php

namespace Phue\Command;

/**
 * Command Interface
 */
interface CommandInterface
{
    /**
     * Get method for command
     *
     * @return string Method name
     */
    public function getMethod();

    /**
     * Get path for command
     *
     * @return string Path name
     */
    public function getPath();

    /**
     * Get data for command
     *
     * @return stdClass Object
     */
    public function getData();
}
