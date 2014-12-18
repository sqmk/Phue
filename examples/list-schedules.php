<?php
/**
 * Example: List schedules.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-schedules.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing schedules:', "\n";

foreach ($client->getSchedules() as $schedule) {
    echo "\t", "#{$schedule->getId()} - {$schedule->getName()}", "\n",
        "\t\t", "Time scheduled: {$schedule->getTime()}", "\n",
        "\t\t", "Method: {$schedule->getCommand()['method']}", "\n",
        "\t\t", "Address: {$schedule->getCommand()['address']}", "\n",
        "\t\t", "Body: ", json_encode($schedule->getCommand()['body']), "\n",
        "\t\t", "Status: ", $schedule->getStatus(), "\n",
        "\t\t", "Autodelete: ", $schedule->isAutoDeleted() ? 'Yes' : 'No', "\n";
}
