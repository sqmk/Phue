<?php
/**
 * Example: Create test sensor.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-sensor.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test sensor', "\n";

$sensorId = $client->sendCommand(
    (new \Phue\Command\CreateSensor('Test sensor'))
        ->modelId('TestSensor')
        ->softwareVersion(1)
        ->type('CLIPGenericFlag')
        ->uniqueId('123.456.789')
        ->manufacturerName('PhueClient')
        ->stateAttribute('flag', true)
        ->configAttribute('on', true)
        ->configAttribute('reachable', true)
        ->configAttribute('battery', 100)
        ->configAttribute('url', 'http://example.org')
);

echo 'Sensor Id: ', $sensorId, "\n";
