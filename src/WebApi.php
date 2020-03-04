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
        // Send the request and get the response
        $client = Factory::getHttp();
        $response = $client->get($this->baseUri . $resource, [
            'query'       => $params,
            'headers'     => ['Content-type: application/json'],
            'http_errors' => true
        ]);

        // Parse the response
        $result = json_decode($response->getBody());

        // Return the result
        return $result;
    }


    /**
     * Get info for a single number
     * -------------------------------------------------------------------------
     * @param  string   $number     The number to lookup
     *
     * @return stdClass
     */
    public function getNumber(string $number)
    {
        // Sanitise the given number
        $number = preg_replace('|[^0-9]|i', '', $number);

        // Lookup the number in the web api
        $result = $this->send("numbers/$number");

        // Return the result
        return $result;
    }



    /**
     * Get a list of numbers from the web api
     * -------------------------------------------------------------------------
     * @param  array    $prefixes   A list of prefixes
     * @param  string   $suffix     A full or partial suffix
     * @param  int      $limit      Max items to return
     * @param  int      $page       Page number
     * @param  string   $orderby    Column to order items by
     * @param  string   $direction  Direct to order items in
     *
     * @return stdClass
     */
    public function getNumbers(array $prefixes = [], string $suffix = '', 
        int $limit = 100, int $page = 1, string $orderby = 'number',
        string $direction = 'asc') : stdClass
    {
        // Get the list from the web api
        $result = $this->send('numbers', [
            'prefix'   => $prefixes,
            'suffix'   => $suffix,
            'limit'    => $limit,
            'page'     => $page,
            'orderby'  => $orderby,
            'orderdir' => $direction
        ]);

        // Return the result
        return $result;
    }


    /**
     * Get info for a single word
     * -------------------------------------------------------------------------
     * @param  string   $number     The word to lookup
     *
     * @return stdClass
     */
    public function getWord(string $word)
    {
        // Sanitise the given number
        $word = preg_replace('|[^0-9A-Z]|i', '', $word);

        // Lookup the number in the web api
        $result = $this->send("words/$word");

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
        if (strlen($suffix) >= 6)

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
