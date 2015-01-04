<?php
/**
 * Example: Update test sensor.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php update-sensor.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Updating test rule', "\n";

$sensor = $client->getSensors()[4];

$client->sendCommand(
    (new \Phue\Command\UpdateSensor($sensor))
        ->name('Test sensor new name')
);

$client->sendCommand(
    (new \Phue\Command\UpdateSensorState($sensor))
        ->stateAttribute('flag', false)
);

$client->sendCommand(
    (new \Phue\Command\UpdateSensorConfig($sensor))
        ->configAttribute('battery', 99)
);
