<?php
/**
 * Example: Create test rule.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-rule.php
 */
require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test rule', "\n";

$sensors = $client->getSensors();
$sensor = $sensors[2];

// TODO $ruleId = $client->sendCommand(
// (new \Phue\Command\CreateRule('Button 1 press'))
// ->addCondition(
// (new \Phue\Condition)
// ->setSensorId($sensor)
// ->setAttribute('buttonevent')
// ->equals()
// ->setValue(\Phue\SensorModel\ZgpswitchModel::BUTTON_2)
// )
// ->addCondition(
// (new \Phue\Condition)
// ->setSensorId($sensor)
// ->setAttribute('lastupdated')
// ->changed()
// )
// ->addAction(
// (new \Phue\Command\SetGroupState(0))
// ->brightness(2)
// )
// );

$rule = new \Phue\Command\CreateRule('Button 1 press');
$cond1 = new \Phue\Condition();
$cond2 = new \Phue\Condition();
$g_state = new \Phue\Command\SetGroupState(0);

$cmd = $rule->addCondition(
    $cond1->setSensorId($sensor)
        ->setAttribute('buttonevent')
        ->equals()
        ->setValue(\Phue\SensorModel\ZgpswitchModel::BUTTON_2))
    ->addCondition(
    $cond2->setSensorId($sensor)
        ->setAttribute('lastupdated')
        ->changed())
    ->addAction($g_state->brightness(2));

$ruleId = $client->sendCommand($cmd);

echo 'Rule Id: ', $ruleId, "\n";
