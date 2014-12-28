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
            $sensor,
            'buttonevent',
            \Phue\Rule::OP_EQUALS,
            \Phue\SensorModel\ZgpswitchModel::BUTTON_2
        )
        ->addCondition(
            $sensor,
            'lastupdated',
            \Phue\Rule::OP_CHANGED
        )
        ->addAction(
            (new \Phue\Command\SetGroupState(0))
                ->brightness(2)
        )
);

echo 'Rule Id: ', $ruleId, "\n";
