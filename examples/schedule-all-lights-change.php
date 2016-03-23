<?php
/**
 * Example: Schedule all lights to change.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php schedule-all-lights-change.php
 */
require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Scheduling lights to dim, then become bright, 3 times, 1 second periods.', "\n";

$x1 = new \Phue\TimePattern\Timer(1);
$y1 = new \Phue\Command\SetGroupState(0);
$z1 = new \Phue\Command\CreateSchedule('Dim all lights', $x1->repeat(3), 
    $y1->brightness(1));
$client->sendCommand($z1);

$x2 = new \Phue\TimePattern\Timer(1);
$y2 = new \Phue\Command\SetGroupState(0);
$z2 = new \Phue\Command\CreateSchedule('Brighten all lights', $x2->repeat(3), 
    $y2->brightness(255));
$client->sendCommand($z2);

echo 'Done.', "\n";
