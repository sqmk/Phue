<?php
/**
 * Example: Update test sensor.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php update-sensor.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Updating test rule', "\n";

// TODO $sensor = $client->getSensors()[4];
$_sensors = $client->getSensors();
$sensor = $_sensors[4];

// TODO $client->sendCommand(
//     (new \Phue\Command\UpdateSensor($sensor))
//         ->name('Test sensor new name')
// );
$x = new \Phue\Command\UpdateSensor($sensor);
$y = $x->name('Test sensor new name');
$client->sendCommand($y);
		
// TODO $client->sendCommand(
//     (new \Phue\Command\UpdateSensorState($sensor))
//         ->stateAttribute('flag', false)
// );
$x = new \Phue\Command\UpdateSensorState($sensor);
$y = $x->stateAttribute('flag', false);
$client->sendCommand($y);

// TODO $client->sendCommand(
//     (new \Phue\Command\UpdateSensorConfig($sensor))
//         ->configAttribute('battery', 99)
// );
$x = new \Phue\Command\UpdateSensorConfig($sensor);
$y = $x->configAttribute('battery', 99);
$client->sendCommand($y);
