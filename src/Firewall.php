<?php
/**
 * =============================================================================
 * @package     Telcoworks Group PHP Library
 * @copyright   Copyright (c) 2020 Telcoworks Group. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @author      David Plath <webmaster@telcoworksgroup.com.au>
 * =============================================================================
 */

namespace TelcoworksGrp\Legacy;


/**
 * Class for allowing/blocking traffic
 */
class Firewall
{

    /**
     * List of 2 or 3 digit country codes to block
     *
     * @var string[]
     */
    protected $bannedCountries = [];



    /**
    * Block access to the site with a given HTTP response code and message
    * ------------------------------------------------------------------------
    * @param int        $code   HTTP response code to send
    * @param string     $msg    Message to send with the response code
    *
    * @return void
    */
    public function block(int $code = null, string $msg = null) : void
    {
        // Initialise some local variables
        $input  = Factory::getInput();
        $config = Factory::getConfig();
        $log    = Factory::getLog();

        // Make sure we have a valid code and message
        $code = (is_null($code)) ?
            $config->get('firewall.block.code', 403) : $code ;
        $msg = (is_null($msg)) ?
            $config->get('firewall.block.message', 'Forbidden') : $msg ;

        // Record the block in the log
        $ip = $input->server('REMOTE_ADDR', '[unknown]');
        Factory::getLog()->notice("Blocked access from $ip");

        // Block the user
        header("HTTP/1.0 $code $msg");
        die();
    }


    /**
     * Add a country that should be banned from the website
     * -------------------------------------------------------------------------
     * @param string    $code   A 2 or 3 charictar country code
     *
     * @return void
     */
    public function addBannedCountry(string $code) : void
    {
        $this->bannedCountries[] = $code;
    }


    /**
     * Gets a list of countries that have been banned
     * -------------------------------------------------------------------------
     * @return string[]
     */
    public function getBannedCountries() : array
    {
        return $this->bannedCountries;
    }


    /**
     * Clear/remove all banned countries
     * -------------------------------------------------------------------------
     * @return void
     */
    public function clearBannedCountries() : void
    {
        $this->bannedCountries = [];
    }


    /**
     * Check if the country for a given ip address is banned
     * -------------------------------------------------------------------------
     * @param  string   $ip   An ip address. Default: remote ip
     *
     * @return bool
     */
    public function isBannedCountry(string $ip = null) : bool
    {
        // Get location info for the ip
        $location = $this->lookupCountry($ip);

        // Get a list of countries that are banned
        $banned = $this->getBannedCountries();

        // Check if the location info matches any banned countries
        $result = in_array($location->country_code2, $banned) OR
            in_array($location->country_code3, $banned);

        // Return the result
        return $result;
    }


    /**
     * Look up location info for a given IP address
     * -------------------------------------------------------------------------
     * @param   string  $ip The ip address to look up, or null for the remote ip
     *
     * @return \stdClass
     */
    public function lookupCountry(string $ip  = null) : \stdClass
    {
        // Initialise some local variables
        $config = Factory::getConfig();
        $input  = Factory::getInput();
        $client = Factory::getHttp();
        $ip     = (is_null($ip)) ? $input->server('REMOTE_ADDR') : $ip;
        $key    = $config->get('firewall.ip2loc.apikey','');

        // Lookup location data in API
        $response = $client->get('https://api.ipgeolocation.io/ipgeo', [
            'query'       => ['apiKey' => $key, 'ip' => $ip],
            'http_errors' => true
        ]);

        // Parse the response
        $result = json_decode($response->getBody());

        // Return the result
        return $result;
    }


    /**
     * Block the user if the remote IP address belongs to a banned country
     * -------------------------------------------------------------------------
     * @return void
     */
    public function blockBannedCountries() : void
    {
        if ($this->isBannedCountry()) {
            $this->block();
        }
    }

}
