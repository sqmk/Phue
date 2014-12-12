<?php
/**
 * Example: Schedule all lights to change.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php schedule-all-lights-change.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Scheduling lights to dim, then become bright.', "\n";

$dimCommand = (new \Phue\Command\SetGroupState(0))
	->brightness(1);

$brightCommand = (new \Phue\Command\SetGroupState(0))
	->brightness(255);

$client->sendCommand(
	new \Phue\Command\CreateSchedule(
	    'Dim all lights',
	    '+5 seconds',
	    $dimCommand
	)
);

$client->sendCommand(
	new \Phue\Command\CreateSchedule(
		'Brighten all lights',
		'+6 seconds',
		$brightCommand
	)
);

echo 'Waiting 10 seconds...', "\n";

sleep(10);

echo 'Done. All reachable lights should have changed.', "\n";
