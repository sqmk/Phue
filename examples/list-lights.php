<?php
/**
 * Example: List lights registered on bridge.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-lights.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing lights:', "\n";

foreach ($client->getLights() as $light) {
    echo "\t", "#{$light->getId()} - {$light->getName()} - {$light->getModel()}", "\n",
        "\t\t", "Unique Id: {$light->getUniqueId()}", "\n";
}
