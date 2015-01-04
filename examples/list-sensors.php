<?php
/**
 * Example: List sensors.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-sensors.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing sensors:', "\n";

foreach ($client->getSensors() as $sensor) {
    echo "\t", "#{$sensor->getId()} - {$sensor->getName()}", "\n",
        "\t\t", "Type: {$sensor->getType()}", "\n",
        "\t\t", "Model Id: {$sensor->getModelId()}", "\n",
        "\t\t", "Manufacturer Name: {$sensor->getManufacturerName()}", "\n",
        "\t\t", "Software Version: {$sensor->getSoftwareVersion()}", "\n",
        "\t\t", "Unique Id: {$sensor->getUniqueId()}", "\n",
        "\t\t", "Model name: {$sensor->getModel()->getName()}", "\n";

    foreach ($sensor->getState() as $key => $value) {
        echo "\t\t", "State - {$key}: ", json_encode($value), "\n";
    }

    foreach ($sensor->getConfig() as $key => $value) {
        echo "\t\t", "Config - {$key}: ", json_encode($value), "\n";
    }
}
