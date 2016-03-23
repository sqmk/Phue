<?php
/**
 * Example: Create test group.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-group.php
 */
require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test group', "\n";

$lights = $client->getLights();

$groupId = $client->sendCommand(
    new \Phue\Command\CreateGroup('Test Group', 
        // TODO [
        // $client->getLights()[4],
        // $client->getLights()[5],
        // ]
        array(
            $lights[4],
            $lights[5]
        )));

echo 'Group Id: ', $groupId, "\n";
