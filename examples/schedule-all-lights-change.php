<?php
/**
 * Example: Schedule all lights to change.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php schedule-all-lights-change.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Scheduling lights to dim, then become bright, 3 times, 1 second periods.', "\n";

$client->sendCommand(
    new \Phue\Command\CreateSchedule(
        'Dim all lights',
        (new \Phue\TimePattern\Timer(1))
            ->repeat(3),
        (new \Phue\Command\SetGroupState(0))
            ->brightness(1)
    )
);

$client->sendCommand(
    new \Phue\Command\CreateSchedule(
        'Brighten all lights',
        (new \Phue\TimePattern\Timer(1))
            ->repeat(3),
        (new \Phue\Command\SetGroupState(0))
            ->brightness(255)
    )
);

echo 'Done.', "\n";
