<?php
/**
 * Example: List rules.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-rules.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing rules:', "\n";

foreach ($client->getRules() as $rule) {
    echo "\t", "#{$rule->getId()} - {$rule->getName()}", "\n",
        "\t\t", "Last Triggered Time: {$rule->getLastTriggeredTime()}", "\n",
        "\t\t", "Creation time: {$rule->getCreationTime()}", "\n",
        "\t\t", "Times triggered: {$rule->getTriggeredCount()}", "\n",
        "\t\t", "Owner: {$rule->getOwner()}", "\n",
        "\t\t", "Status: ", $rule->isEnabled() ? 'Yes' : 'No', "\n";
}
