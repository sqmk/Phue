<?php
/**
 * Example: Delete a schedule.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php delete-schedule.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Deleting schedule 1:', "\n";

$client->getSchedules()[1]->delete();

echo 'Done.', "\n";
