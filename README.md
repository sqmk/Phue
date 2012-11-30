## Phue - Philips Hue PHP Client

Master: [![CI Status](https://secure.travis-ci.org/sqmk/Phue.png?branch=master)](http://travis-ci.org/sqmk/Phue)

Phue is a PHP 5.4 client used to connect to and manage the Philips Hue lighting system.

It is currently registered with Packagist so that this library can easily be included in other projects. For example, one may want to bundle this library with Zend Framework or Symfony to build their own front-end for the Hue system.

Currently, the client's only capabilities are:
* Testing connection to the bridge
* Authenticatication with the bridge
* Starting scan of new lights
* Getting a list of new lights found by active/previous scan

## Authentication

To test connectivity and authenticate with the bridge, you can use the ```phue-authenticate``` script included in the ```bin``` directory. The script uses the Phue library to make requests and receive responses from the Philips Hue bridge.

First, you will want to determine the ip address of the bridge on your local network. I have created a wiki page that describes a few convenient ways of finding it: [Finding Philips Hue bridge on network](/sqmk/Phue/wiki/Finding-Philips-Hue-bridge-on-network).

Next, if you haven't already, run ```composer install``` in the root directory of this repo. This will install dependencies, and set up class/namespacing mapping for autoloader for the Phue library. The authenticator script expects the autoloader to be installed. If you are not familiar with Composer, check out the project here: [Composer](http://getcomposer.org).

At this point, you should be ready to authenticate with the bridge. The bridge expects a 32 character hash as a username to authenticate with, but you can feed in any string into the client and it will automatically hash for you. This is much easier to remember than the hash!

Here's how to run the script for authenticating:

```
$ ./bin/phue-authenticate 10.0.1.31 your.username
```

If the connection is ok, you will get a response similar to this:

```
! - Username your.username doesn't appear to be 32 character hash (A-F, 0-9)
! - Using this for username instead: af8caecf12655838d10fa92d86d09e82

Testing connection to bridge at 10.0.1.31
Response appears OK!

Attempting to authenticate (af8caecf12655838d10fa92d86d09e82):
Press the Bridge's button!
Waiting.....
```

The ```phue-authenticate``` script will attempt to authenticate with the bridge once every second. The bridge's connection button (the big round lit up one) needs to be pressed while the script runs. If the button is pressed during execution of the script, you should get a response like this:

```
! - Username your.username doesn't appear to be 32 character hash (A-F, 0-9)
! - Using this for username instead: af8caecf12655838d10fa92d86d09e82

Testing connection to bridge at 10.0.1.31
Response appears OK!

Attempting to authenticate (af8caecf12655838d10fa92d86d09e82):
Press the Bridge's button!
Waiting......
Authentication for user your.username was successful!
```

From then on, you should be able to use the final username for interacting with the Philips Hue bridge!

## Scanning / registering new lights

Now that you have tested connection and authentication to the bridge, you can now register your lights using the Phue client.

Another convenience script has been created to demonstrate how to use Phue to get the bridge to start scanning for and retrieving new lights. This script is ```phue-light-finder```, and it is also located in the ```bin``` directory.

You can pass the same arguments for ```phue-light-finder``` as you did with ```phue-authenticate```. Here's how to use the script:

```
$ ./bin/phue-light-finder 10.0.1.31 your.username
```

Example results are as follows:

```
! - Username your.username doesn't appear to be 32 character hash (A-F, 0-9)
! - Using this for username instead: af8caecf12655838d10fa92d86d09e82

Testing connection to bridge at 10.0.1.31
Response appears OK!

Scanning for lights. Turn at least one light off, then on...
Found: Light #1, Hue Lamp 1
Found: Light #2, Hue Lamp 2
Found: Light #3, Hue Lamp 3
Done scanning
```

Now that you have found and registered new lights with the bridge, you can now manage the lights! If you happen to add additional Hue lights to your home, you can use the Phue client and/or this script to invoke scanning and retrieving them.