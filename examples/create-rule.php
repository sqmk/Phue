<?php
/**
 * Example: Create test rule.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-rule.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test rule', "\n";

$sensor = $client->getSensors()[2];

$ruleId = $client->sendCommand(
    (new \Phue\Command\CreateRule('Button 1 press'))
        ->addCondition(
            (new \Phue\Condition)
                ->setSensorId($sensor)
                ->setAttribute('buttonevent')
                ->equals()
                ->setValue(\Phue\SensorModel\ZgpswitchModel::BUTTON_2)
        )
        ->addCondition(
            (new \Phue\Condition)
                ->setSensorId($sensor)
                ->setAttribute('lastupdated')
                ->changed()
        )
        ->addAction(
            (new \Phue\Command\SetGroupState(0))
                ->brightness(2)
        )
);

echo 'Rule Id: ', $ruleId, "\n";
