<?php
/**
 * Phue: Philips Hue PHP Client
 *
 * @author    Michael Squires <sqmk@php.net>
 * @copyright Copyright (c) 2012 Michael K. Squires
 * @license   http://github.com/sqmk/Phue/wiki/License
 */

namespace Phue\Command;

use Phue\Client;
use Phue\Rule;

/**
 * Get rules command
 */
class GetRules implements CommandInterface
{
    /**
     * Send command
     *
     * @param Client $client Phue Client
     *
     * @return Rule[] List of Rule objects
     */
    public function send(Client $client)
    {
        // Get response
        $results = $client->getTransport()->sendRequest(
            "/api/{$client->getUsername()}/rules"
        );

        $rules = [];

        foreach ($results as $ruleId => $attributes) {
            $rules[$ruleId] = new Rule($ruleId, $attributes, $client);
        }

        return $rules;
    }
}
