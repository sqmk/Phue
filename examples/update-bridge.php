<?php
/**
 * Example: Update bridge.
 *
 * Usage: HUE_HOST=127.0.0.1 HUE_USERNAME=1234567890 php update-bridge.php
 */

require_once 'common.php';

$client         = new \Phue\Client($hueHost, $hueUsername);
$bridge         = $client->getBridge();
$softwareUpdate = $bridge->getSoftwareUpdate();

echo 'Checking if bridge needs updating.', "\n";

if ($softwareUpdate->isBridgeUpdatable()) {
    echo 'Update available!', "\n",
        'Release notes URL: ', $softwareUpdate->getReleaseNotesUrl(), "\n",
        'Release notes brief: ', $softwareUpdate->getReleaseNotesBrief(), "\n";

    $updateState = [
        \Phue\SoftwareUpdate::STATE_NO_UPDATE        => 'No updates.',
        \Phue\SoftwareUpdate::STATE_DOWNLOADING      => 'Downloading updates.',
        \Phue\SoftwareUpdate::STATE_READY_TO_INSTALL => 'Ready to install.',
        \Phue\SoftwareUpdate::STATE_INSTALLING       => 'Installing.',
    ];

    echo 'Update state: ', $updateState[$softwareUpdate->getUpdateState()], "\n";

    if ($softwareUpdate->getUpdateState() == \Phue\SoftwareUpdate::STATE_READY_TO_INSTALL) {
        $softwareUpdate->installUpdates();

        echo 'Updating bridge.', "\n";
    }
} else {
    echo 'No bridge updates available.', "\n";
}
