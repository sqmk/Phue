<?php
/**
 * Example: Delete test group.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php delete-group.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);

echo 'Deleting group 1:', "\n";

$client->getGroups()[1]->delete();

echo "Done.", "\n";
