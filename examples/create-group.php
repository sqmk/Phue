<?php
/**
 * Example: Create test group.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-group.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test group', "\n";

$groupId = $client->sendCommand(
    new \Phue\Command\CreateGroup(
        'Test Group',
        [
            $client->getLights()[4],
            $client->getLights()[5],
        ]
    )
);

echo 'Group Id: ', $groupId, "\n";
