<?php
/**
 * Example: Set bridge config.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php set-bridge-config.php
 */

require_once 'common.php';

$client = new \Phue\Client($hueHost, $hueUsername);
$bridge = $client->getBridge();

// Turn bridge link button on.
$bridge->setLinkButtonOn(true)
    ->setTimezone('America/Los_Angeles')
    ->enableDhcp(true)
    ->setProxyAddress()
    ->setProxyPort();
