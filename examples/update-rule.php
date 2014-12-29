<?php
/**
 * Example: Update test rule.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php update-rule.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Updating test rule', "\n";

$sensor = $client->getSensors()[2];
$rule = $client->getRules()[5];

$client->sendCommand(
    (new \Phue\Command\UpdateRule($rule))
        ->name('New name')
        ->addCondition(
            (new \Phue\Condition)
                ->setSensorId($sensor)
                ->setAttribute('lastupdated')
                ->changed()
        )
        ->addAction(
            (new \Phue\Command\SetGroupState(0))
                ->brightness(200)
        )
);
