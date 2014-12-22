<?php
/**
 * Example: Schedule all lights to change, recurring date.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php schedule-recurring.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Dim all lights every Thursday and Saturday at 7:50 UTC.', "\n";

$timePattern = new \Phue\TimePattern\RecurringTime(
    \Phue\TimePattern\RecurringTime::THURSDAY | \Phue\TimePattern\RecurringTime::SATURDAY,
    7,
    50
),

$client->sendCommand(
    new \Phue\Command\CreateSchedule(
        'Dim all lights',
        $timePattern,
        (new \Phue\Command\SetGroupState(0))
            ->brightness(1)
    )
);

echo 'Done.', "\n";
