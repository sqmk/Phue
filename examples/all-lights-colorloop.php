<?php
/**
 * Example: All lights to colorloop effect.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php all-lights-colorloop.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Setting all lights to colorloop effect.', "\n";

$client->sendCommand(
    (new \Phue\Command\SetGroupState(0))
        ->effect('colorloop')
);
