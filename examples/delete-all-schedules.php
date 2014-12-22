<?php
/**
 * Example: Delete all schedules.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php delete-all-schedules.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Deleting all schedules:', "\n";

foreach ($client->getSchedules() as $scheduleId => $schedule) {
	$schedule->delete();

	echo "{$schedule->getId()} deleted", "\n";
}

echo 'Done.', "\n";
