<?php
/**
 * Example: List users.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php list-users.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Listing users:', "\n";

foreach ($client->getUsers() as $user) {
    echo "\t", "{$user->getUsername()} - {$user->getDeviceType()}", "\n",
        "\t\t", "Create date: {$user->getCreateDate()}", "\n",
        "\t\t", "Last use date: {$user->getLastUseDate()}", "\n";
}
