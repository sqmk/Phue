<?php
/**
 * Example: Candle effect.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php candle-effect.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Starting candle effect.', "\n";

while (true) {
    // Randomly choose values
    $brightness     = rand(20, 60);
    $colorTemp      = rand(440, 450);
    $transitionTime = rand(0, 3) / 10;

    // Send command
    $client->sendCommand(
        (new \Phue\Command\SetLightState(4))
            ->brightness($brightness)
            ->colorTemp($colorTemp)
            ->transitionTime($transitionTime)
    );

    // Sleep for transition time plus extra for request time
    usleep($transitionTime * 1000000 + 25000);
}
