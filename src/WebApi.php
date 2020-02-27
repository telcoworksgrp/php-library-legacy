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
 * Class for interacting with the Telcoworks Group Web API
 */
class WebApi
{

    /**
     * Base URI for all API endpoints
     *
     * @var string
     */
    protected $baseUri = 'https://api.telcoworksgroup.com.au/';




    /**
     * Send a request to the api and return the result as an object
     * -------------------------------------------------------------------------
     * @param  string    $resource  Relative URI to the resource
     * @param  array     $params    HTTP params to send with the requst
     *
     * @return mixed
     */
    public function send(string $resource, array $params = [])
    {
        // Send the request
        $response = Helper::sendRequest($this->baseUri . $resource,
            'GET', $params, ['Content-type: application/json']);

        // Decode JSON response
        $result = json_decode($response);

        // Return the result
        return $result;
    }



    /**
     * Perform a simple number search and return a list of both results and
     * suggestions
     * -------------------------------------------------------------------------
     * @param  array  $prefixes     A list of number prefixes
     * @param  string $suffix       A full or partical number suffix
     *
     * @return \stdClass
     */
    public function search(array $prefixes = [], string $suffix = '000000')
    {
        // Initialise some local variables
        $result = new \stdClass;

        // Get a list of results
        $result->results = $this->send('numbers', [
            'prefix' => $prefixes,
            'suffix' => $suffix
        ]);

        // Get a list of suggestions
        $result->suggestions = $this->send('suggestions', [
            'prefix' => $prefixes,
            'suffix' => $suffix
        ]);

        // Return the result
        return $result;
    }

}
