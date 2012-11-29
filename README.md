## Phue - Philips Hue PHP Client

Phue is a PHP 5.4 client used to connect to and manage the Philips Hue lighting system.

It is currently registered with Packagist so that this library can easily be included in other projects. For example, one may want to bundle this library with Zend Framework or Symfony to build their own front-end for the Hue system.

## Authentication

Currently, the client's only capabilities are to test connection of the bridge, and to authenticate with said bridge.

To test connectivity and authenticate with the bridge, you can use the phue-authenticate script included in the ```bin``` directory.

First, you will want to determine the ip address of the bridge on your local network. I have created a wiki page that describes a few convenient ways of finding it: [Finding Philips Hue bridge on network](/sqmk/Phue/wiki/Finding-Philips-Hue-bridge-on-network).

Next, if you haven't already, run ```composer install``` in the root directory of this repo. This will install dependencies, and set up class/namespacing mapping for autoloader for the Phue library. The authenticator script expects the autoloader to be installed. If you are not familiar with Composer, check out the project here: [Composer](http://getcomposer.org).

At this point, you should be ready to authenticate with the bridge. The bridge expects a 32 character hash as a username to authenticate with, but you can feed in any string into the phue-authenticate script, and if need be, it will hash automatically for you. Here's how to run the script:

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

The phue-authenticate script will attempt to authenticate with the bridge once every second. The bridge's connection button (the big round lit up one) needs to be pressed while the script runs. If the button is pressed during execution of the script, you should get a response like this:

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

