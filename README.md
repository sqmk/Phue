# Phue - Philips Hue client for PHP

[![Latest Stable Version](https://poser.pugx.org/sqmk/Phue/version)](https://packagist.org/packages/sqmk/Phue)
[![Build Status](https://api.travis-ci.org/sqmk/Phue.svg?branch=master)](https://travis-ci.org/sqmk/Phue)

## Introduction

Phue is a PHP client used to connect to and manage the Philips Hue lighting system.

It is currently registered with Packagist so that this library can easily be included in other projects. For example, one may want to bundle this library with Zend Framework or Symfony to build their own front-end for the Hue system.

The client has the ability to make full use of the Hue's API, including:
* Authenticating and managing users
* Managing bridge configuration
* Managing lights
* Managing groups
* Managing sensors
* Managing rules for sensors
* Managing schedules with various time patterns
* Managing software updates to the bridge and lights
* Getting portal configuration

Interested in API docs? You can check out the auto-generated documentation at [GitApiDoc](http://gitapidoc.com/api/sqmk/Phue/)

## Requirements

* PHP 5.4+
* cURL extension (optional)

## Installation

The Phue library is available in Packagist. You'll want to include ```sqmk/phue``` as a dependency in your project using composer. If you are not familiar with composer, check it out here: [Composer](http://getcomposer.org)

You can also use this library without composer. The library directory is ```library```. You'll want to map your namespace ```Phue``` to this directory in your autoloader of choice.

The scripts in ```bin``` and ```examples``` are dependent on composer's class/namespace mapper within ```vendor```. You'll need to ```composer install``` from root directory of this repo to get those working.

After all the packages are installed, include composer's generated autoloader. The autoloader is ```vendor/autoload.php```. An example of including this from the root directory of this repository:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new \Phue\Client('10.0.1.1', 'yourusername');
```

## Usage

For all examples, it is assumed that the autoloader is included somewhere in your PHP app.

To start, you'll need to instantiate a new Phue Client object. You'll need the IP of your bridge, and an authenticated key/username. If you don't know the IP of your bridge or haven't authenticated a user, you can use the helper scripts documented at the end of the README.

Here's how to instantiate a client object:

```php
<?php

$client = new \Phue\Client('10.0.1.31', 'sqmk');
```

### Issuing commands, testing connection and authorization

You can issue a Ping command to the bridge to test making a request to it. If a ConnectionException exception is thrown, then there is a problem with talking to the bridge:

```php
try {
	$client->sendCommand(
		new \Phue\Command\Ping
	);
} catch (\Phue\Transport\Exception\ConnectionException $e) {
	echo 'There was a problem accessing the bridge';
}
```

In the above example, you'll notice that to send a command, you instantiate a command object, and then pass the command to the client using the ```sendCommand``` method. There is also another way to send commands that may be a bit more elegant. Here is another way to issue commands to the bridge via the client:

```php
try {
	(new \Phue\Command\Ping)->send($client);
} catch (\Phue\Transport\Exception\ConnectionException $e) {
	echo 'There was a problem accessing the bridge';
}
```

All commands can be issued in a similar manner as the previous two examples.

Once you have determined you can make requests to the bridge, you can test if the username you provided is available.

```php
$isAuthenticated = $client->sendCommand(
	new \Phue\Command\IsAuthorized
);

echo $isAuthenticated
   ? 'You are authenticated!'
   : 'You are not authenticated!';
```

If the username provided is not created, you can use the convenience script to authenticate, which is documented later in this README. Or, you can use the CreateUser command to do it yourself.

```php
// Push the bridge's link button prior to running this
try {
	$response = $client->sendCommand(
		new \Phue\Command\CreateUser
	);

	echo 'New user created: ' . $response->username;
} catch (\Phue\Transport\Exception\LinkButtonException $e) {
	echo 'The link button was not pressed!';
}
```

After the user is created, you won't have to create it again unless you reset the bridge!

### Managing lights

Now that you have an authorized user, you can start managing the lights with the client.

There are a couple of ways to retrieve the list of lights that are registered with the bridge. You can use the helper method available from the client, or by manually issuing a command to the client. These commands return an array of ```\Phue\Light``` objects:

```php
// From the client
foreach ($client->getLights() as $lightId => $light) {
	echo "Id #{$lightId} - {$light->getName()}", "\n";
}

// Or from command
$lights = $client->sendCommand(
	new \Phue\Command\GetLights
);

foreach ($lights as $lightId => $light) {
	echo "Id #{$lightId} - {$light->getName()}", "\n";
}
```

You can also retrieve a single light. You can either dereference from the list of lights via ```getLights``` from the client, or pass in a manual command to the client:

```php
// Retrieve light of id 3 from convenience method
$light = $client->getLights()[3];

echo $light->getName(), "\n";

// Manually send command to get light of id 3
$light = $client->sendCommand(
	new \Phue\Command\GetLightById(3)
);

echo $light->getName(), "\n";
```

Don't have any lights, or need to register a new bulb? The ```StartLightScan``` command and the ```GetNewLights``` command can be used to help registering new lights.  You can see how these commands are used by looking at the ```bin/phue-light-finder``` script, which is documented at the end of this README.

Now that you can retrieve ```\Phue\Light``` objects, you can start manipulating them with the client. Here are a few examples of how to show and change a light's properties:

```php
// Get a specific light
$light = $client->getLights()[3];

// Retrieving light properties:
echo $light->getId(), "\n",
     $light->getName(), "\n",
     $light->getType(), "\n",
     $light->getModelId(), "\n",
     $light->getSoftwareVersion(), "\n",
     $light->isOn(), "\n",
     $light->getAlert(), "\n",
     $light->getBrightness(), "\n",
     $light->getHue(), "\n",
     $light->getSaturation(), "\n",
     $light->getXY()['x'], "\n",
     $light->getXY()['y'], "\n",
     $light->getEffect(), "\n",
     $light->getColorTemp(), "\n",
     $light->getColorMode(), "\n";

// Setting name
$light->setName('Living Room #1');

// Setting on/off state (true|false)
$light->setOn(true);

// Setting alert (select|lselect)
$light->setAlert('lselect');

// Setting brightness (0 for no light, 255 for max brightness)
$light->setBrightness(255);

// Set hue (0 to 65535), pairs with saturation, changes color mode to 'hs'
$light->setHue(56000);

// Set saturation (0 min, 255 max), pairs with hue, changes color mode to 'hs'
$light->setSaturation(255);

// Set xy, CIE 1931 color space (from 0.0 to 1.0 for both x and y)
// Changes color mode to 'xy'
$light->setXY(0.25, 0.5);

// Set color temp (153 min, 500 max), changes color mode to 'ct'
$light->setColorTemp(300);

// Set effect (none|colorloop)
$light->setEffect('colorloop');
```

Each *set* method above issues a single request to the bridge. In order to update multiple attributes of a light with a single request, the ```SetLightState``` command should be used manually. You also get access to the *transition time* option with the command.

```php
// Retrieve light
$light = $client->getLights()[3];

// Setting the brightness, hue, and saturation at the same time
$command = new \Phue\Command\SetLightState($light);
$command->brightness(200)
        ->hue(0)
        ->saturation(255);

// Transition time (in seconds).
// 0 for "snapping" change
// Any other value for gradual change between current and new state
$command->transitionTime(3);

// Send the command
$client->sendCommand(
    $command
);

```

### Managing groups

The bridge API allows you to create, update, and delete groups. Groups are useful for controlling multiple lights at the same time.

Creating a group is easy. All you need is a name, and a list of lights (ids, or ```\Phue\Light``` obejcts) that you want to associate with the group:

```php
// Create group with list of ids, and get group
$groupId = $client->sendCommand(
	new \Phue\Command\CreateGroup('Office Lights', [1, 2])
);

$group = $client->getGroups()[$groupId];

// Create group with list of lights, and get group
$groupId2 = $client->sendCommand(
	new \Phue\Command\CreateGroup(
		'Office Lights #2',
		[
			$client->getLights()[1],
			$client->getLights()[2],
		]
	)
);

$group = $client->getGroups()[$groupId2];
```

There are multiple ways of retrieving groups. Each way returns either an array or single instance of ```Phue\Group``` objects:

```php
// Convenient way of retrieving groups
foreach ($client->getGroups() as $groupId => $group) {
	echo $group->getId(), ' - ',
	     $group->getName(), "\n";
}

// Manual command for retrieving groups
$groups = $client->sendCommand(
	new \Phue\Command\GetGroups
);

foreach ($client->getGroups() as $groupId => $group) {
	echo $group->getId(), ' - ',
	     $group->getName(), "\n";
}

// Convenient way of retrieving a single group by id
$group = $client->getGroups()[1];

echo $group->getId(), ' - ',
     $group->getName(), "\n";

// Manual command for retrieving group by id
$group = $client->sendCommand(
	new \Phue\Command\GetGroupById(1)
);

echo $group->getId(), ' - ',
     $group->getName(), "\n";
```

Most of the methods available on ```\Phue\Light``` objects are also available on ```\Phue\Group``` objects:

```php
// Get a specific group
$group = $client->getGroups()[1];

// Retrieving group properties:
echo $group->getId(), "\n",
     $group->getName(), "\n",
     implode(', ', $group->getLightIds()), "\n",
     $group->isOn(), "\n",
     $group->getBrightness(), "\n",
     $group->getHue(), "\n",
     $group->getSaturation(), "\n",
     $group->getXY()['x'], "\n",
     $group->getXY()['y'], "\n",
     $group->getColorTemp(), "\n",
     $group->getColorMode(), "\n",
     $group->getEffect(), "\n";

// Setting name
$group->setName('Office');

// Setting lights
$group->setLights([
    $client->getLights()[1],
    $client->getLights()[2]
]);

// Setting on/off state (true|false)
$group->setOn(true);

// Setting brightness (0 for no light, 255 for max brightness)
$group->setBrightness(255);

// Set hue (0 to 65535), pairs with saturation, changes color mode to 'hs'
$group->setHue(56000);

// Set saturation (0 min, 255 max), pairs with hue, changes color mode to 'hs'
$group->setSaturation(255);

// Set xy, CIE 1931 color space (from 0.0 to 1.0 for both x and y)
// Changes color mode to 'xy'
$group->setXY(0.25, 0.5);

// Set color temp (153 min, 500 max), changes color mode to 'ct'
$group->setColorTemp(300);

// Set effect (none|colorloop)
$group->setEffect('colorloop');
```

Just like the bulbs, each *set* method on the ```\Phue\Group``` object will send a request for each call. To minimize calls and to change multiple properties on the group at once, use the ```SetGroupState``` command. The ```SetGroupState``` command has all the options as ```SetLightState```.

```php
// Retrieve group
$group = $client->getGroups()[1];

// Setting the brightness, color temp, and transition at the same time
$command = new \Phue\Command\SetGroupState($group);
$command->brightness(200)
        ->colorTemp(500)
        ->transitionTime(0);

// Send the command
$client->sendCommand(
    $command
);
```

Deleting a group is also simple. You can either delete from the ```\Phue\Group``` object, or issue a command:

```php
// Retrieve group and delete
$group = $client->getGroups()[1];
$group->delete();

// Send command
$client->sendCommand(
	new \Phue\Command\DeleteGroup(2)
);
```

There's a special "all" group that can be retrieved with the ```GetGroupById``` command. This group normally has all lights associated with it. You can retrieve this group by passing *id* 0 to the ```GetGroupById``` command:

```php
// Get all group
$allGroup = $client->sendCommand(
	new \Phue\Command\GetGroupById(0)
);

// Set brightness on all bulbs
$allGroup->setBrightness(255);
```

### Managing Schedules

The bridge has the ability to handle scheduling commands at a given time. Schedules, unfortunately, are not reoccurring. The bridge will delete a schedule once it fires the scheduled command.

Retrievable commands will return an array or single instance of a ```\Phue\Schedule``` object. It is not possible to edit a schedule, but deleting is permitted.

```php
// Create command to dim all lights
$groupCommand = new \Phue\Command\SetGroupState(0);
$groupCommand->brightness(30);

// Create schedule command to run 10 seconds from now
// Time is a parsable DateTime date.
$scheduleCommand = new \Phue\Command\CreateSchedule(
	'Dim all lights',
	'+10 seconds',
	$groupCommand
);

// Set a custom description on the schedule, defaults to name
$scheduleCommand->description('Dims all lights in house to 30');

// Send the schedule to bridge
$client->sendCommand($scheduleCommand);

// Show list of schedules
foreach ($client->getSchedules() as $scheduleId => $schedule) {
	echo $schedule->getId(), "\n",
	     $schedule->getName(), "\n",
	     $schedule->getDescription(), "\n",
	     $schedule->getTime(), "\n",
	     $schedule->getCommand()['address'], "\n",
	     $schedule->getCommand()['method'], "\n",
	     json_encode($schedule->getCommand()['body']), "\n";
}

// Delete a given schedule
$schedule = $client->getSchedules()[2];
$schedule->delete();
```

If you noticed in the above example, a ```Actionable``` command must be passed to ```CreateSchedule```. The only commands that are actionable are:
* ```SetLightState```
* ```SetGroupState```

### Don't have the cURL extension?

Don't have the cURL extension compiled with your PHP install? You can override the transport adapter and use PHP's native streaming functions instead.

```php
// Instantiate a client object
$client = new \Phue\Client('10.0.1.1', 'yourusername');

// Override the default transport
$client->setTransport(
	new \Phue\Transport\Adapter\Streaming
);
```

### Other commands

Not all commands have been documented. You can view all the available commands by looking in the ```library/Phue/Command/``` directory.

Some notable commands not yet documented include managing the bridge itself.
* ```\Phue\Command\GetBridge```
* ```\Phue\Command\SetBridgeConfig```

## Example/convenience scripts

There are a few scripts included in this package which serve as both convenience and further examples of using the client.

### Finding your Bridge

Included in this package is ```bin/phue-bridge-finder```, a script that will help find your Philips Hue bridges on your network. When plugging in your bridge into your router with an internet connection, the bridge will phone home to Philips *meethue* servers. The bridge will periodically send its assigned network IP and MAC address to *meethue*. Philips *meethue* service allows iPhone and Android apps to pull a list of the bridges directly from their servers by matching IPs originating from your requesting devices and bridges. ```bin/phue-bridge-finder``` uses same technique.

Prior to running this script, make sure your bridge is powered up and linked to your router. All lights should be lit up on the bridge.

Here's how to run this script:
```
$ ./bin/phue-bridge-finder
```

Assuming all goes well, you'll get results like this:
```
Philips Hue Bridge Finder

Checking meethue.com if the bridge has phoned home:
  Request succeeded

Number of bridges found: 1
	Bridge #1
		ID: 001788fffe09dddd
		Internal IP Address: 10.0.1.31
		MAC Address: 00:17:88:09:dd:dd
```

The internal IP address(es) listed in the results is what you need for the Phue client.

If the script provided doesn't find your bridge, or if you don't have internet connection on your network, I have created a wiki page that describes a few other convenient ways of finding it: [Finding Philips Hue bridge on network](/sqmk/Phue/wiki/Finding-Philips-Hue-bridge-on-network).

### Authentication / Creating a User

To test connectivity and authenticate with the bridge, you can use ```bin/phue-create-user```. The script uses the Phue library to make requests and receive responses from the Philips Hue bridge.

At this point, you should be ready to authenticate with the bridge. The bridge will generate a username for you.

Here's how to run the script for authenticating/creating a user:

```
$ ./bin/phue-create-user 10.0.1.31
```

If the connection is ok, you will get a response similar to this:

```
Testing connection to bridge at 10.0.1.31
Attempting to create user:
Press the Bridge's button!
Waiting.........
```

The ```phue-create-user``` script will attempt to create a user on the bridge once every second. The bridge's connection button (the big round lit up one) needs to be pressed while the script runs. If the button is pressed during execution of the script, you should get a response like this:

```
Testing connection to bridge at 10.0.1.31
Attempting to create user:
Press the Bridge's button!
Waiting..........

Successfully created new user: abcdef0123456 
```

From then on, you should be able to use the username generated for interacting with the Philips Hue bridge!

### Scanning / registering new lights

Now that you have tested connection and authentication to the bridge, you can now register your lights using the Phue client.

Another convenience script has been created to demonstrate how to use Phue to get the bridge to start scanning for and retrieving new lights. This script is ```phue-light-finder```, and it is also located in the ```bin``` directory.

You can pass the same arguments for ```phue-light-finder``` as you did with ```phue-create-user```. Here's how to use the script:

```
$ ./bin/phue-light-finder 10.0.1.31 yourusername
```

Example results are as follows:

```
Testing connection to bridge at 10.0.1.31
Scanning for lights. Turn at least one light off, then on...
Found: Light #1, Hue Lamp 1
Found: Light #2, Hue Lamp 2
Found: Light #3, Hue Lamp 3
Done scanning
```

Now that you have found and registered new lights with the bridge, you can now manage the lights! If you happen to add additional Hue lights to your home, you can use the Phue client and/or this script to invoke scanning and retrieving them.

### More examples

If you are interested in seeing examples for all sorts of commands, check out the ```examples``` directory.
