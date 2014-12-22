<?php
/**
 * Example: List scenes registered on bridge.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-scenes.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing scenes:', "\n";

foreach ($client->getScenes() as $scene) {
    echo "\t", "#{$scene->getId()} - {$scene->getName()}", "\n",
    	"\t\t", "Light Ids: ", implode(', ', $scene->getLightIds()), "\n",
    	"\t\t", "Is active: ", $scene->isActive() ? 'Yes' : 'No', "\n";
}
