<?php
/**
 * Example: List timezones.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-timezones.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing timezones:', "\n";

foreach ($client->getTimezones() as $timezone) {
	echo $timezone, "\n";
}
