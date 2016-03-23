<?php
/**
 * Example: Create test scene, set state, and assign to group.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php create-scene-state.php
 */
require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Creating test scene', "\n";

$sceneId = 'phue-test';
$lightIds = array(
    4,
    5
);

// Create/modify scene
$client->sendCommand(
    new \Phue\Command\CreateScene($sceneId, 'Test Scene', $lightIds));

echo 'Buffering light states', "\n";

// Iterate through each light and buffer state
foreach ($lightIds as $lightId) {
    $x = new \Phue\Command\SetSceneLightState($sceneId, $lightId);
    $y = $x->brightness(255)
        ->hue(50000)
        ->transitionTime(0);
    $client->sendCommand($y);
}

echo 'Done.', "\n";
