<?php
/**
 * Example: All lights to a scene.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php all-lights-scene.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Setting all lights to a scene.', "\n";

$client->sendCommand(
    (new \Phue\Command\SetGroupState(0))
        ->scene('phue-test')
);
