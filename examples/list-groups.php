<?php
/**
 * Example: List groups registered on bridge.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-groups.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing groups:', "\n";

foreach ($client->getGroups() as $group) {
    echo "\t", "#{$group->getId()} - {$group->getName()}", "\n",
        "\t\t Type: ", $group->getType(), "\n",
        "\t\t Lights: ", implode(', ', $group->getLightIds()), "\n";
}
