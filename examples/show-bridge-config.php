<?php
/**
 * Example: Show bridge config.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php show-bridge-config.php
 */

require_once 'common.php';

$client         = new \Phue\Client($hueHost, $hueUsername);
$bridge         = $client->getBridge();
$portal         = $bridge->getPortal();
$softwareUpdate = $bridge->getSoftwareUpdate();

echo 'Showing bridge configuration', "\n",
    "\t Name: ", $bridge->getName(), "\n",
    "\t ZigBee Channel: ", $bridge->getZigBeeChannel(), "\n",
    "\t MAC Address: ", $bridge->getMacAddress(), "\n",
    "\t IP Address: ", $bridge->getIpAddress(), "\n",
    "\t Netmask: ", $bridge->getNetmask(), "\n",
    "\t Gateway: ", $bridge->getGateway(), "\n",
    "\t Proxy: ", "{$bridge->getProxyAddress()}:{$bridge->getProxyPort()}", "\n",
    "\t UTC Time: ", $bridge->getUtcTime(), "\n",
    "\t Local Time: ", $bridge->getLocalTime(), "\n",
    "\t Timezone: ", $bridge->getTimezone(), "\n",
    "\t Software Version: ", $bridge->getSoftwareVersion(), "\n",
    "\t API Version: ", $bridge->getAPIVersion(), "\n",
    "\t Link button: ", $bridge->isLinkButtonOn() ? 'On' : 'Off', "\n",
    "\t Portal services: ", $bridge->arePortalServicesEnabled() ? 'Enabled' : 'Disabled', "\n",
    "\t Portal connected: ", $bridge->isPortalConnected() ? 'Yes': 'No', "\n\n";

echo 'Showing portal configuration', "\n",
    "\t Signed on: ", $portal->isSignedOn() ? 'Yes' : 'No', "\n",
    "\t Incoming: ", $portal->isIncoming() ? 'Yes' : 'No', "\n",
    "\t Outgoing: ", $portal->isOutgoing() ? 'Yes' : 'No', "\n",
    "\t Communication: ", $portal->getCommunication(), "\n\n";

echo 'Showing software update configuration', "\n",
    "\t Checking for update: ", $softwareUpdate->checkingForUpdate() ? 'Yes' : 'No', "\n",
    "\t Bridge updatable: ", $softwareUpdate->isBridgeUpdatable() ? 'Yes' : 'No', "\n",
    "\t Lights updatable: ", implode(', ', $softwareUpdate->getUpdatableLights()), "\n",
    "\t Release notes URL: ", $softwareUpdate->getReleaseNotesUrl(), "\n",
    "\t Release notes brief: ", $softwareUpdate->getReleaseNotesBrief(), "\n",
    "\t Install notification: ", $softwareUpdate->isInstallNotificationEnabled() ? 'Yes' : 'No', "\n\n";
