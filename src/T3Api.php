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
 * Class for interacting with the T3 API
 */
class T3Api
{

    /**
     * Base URI for all API endpoints
     *
     * @var string
     */
    protected $baseUri = 'https://portal.tbill.live/numbers-service-impl/api/';




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
     * Get a list of numbers from the api
     * -------------------------------------------------------------------------
     * @param  string   $prefix     Numbe prefix ('1300' or '1800')
     * @param  string   $type       Type of numbers to get ('FLASH' or 'LUCKYDIP')
     * @param  int      $minPrice   Minimum number price
     * @param  int      $maxPrice   Max number price
     * @param  int      $page     Page to start at
     * @param  int      $limit   Max numbers per page
     * @param  string   $sortBy     Column to sort the results by
     * @param  string   $direction  Direction to sort the results by
     *
     * @return  object[]    A list of numbers with meta data
     */
    public function getNumbers($prefix = '1300', $type = 'FLASH',
        $minPrice = 0, $maxPrice = 10000, $page = 1, $limit = 10000,
        $sortBy = 'PRICE', $direction = 'ASCENDING')
    {

        // Get the data from the API
        $result = $this->send('Activations', [
            'query'              => $prefix,
            'numberTypes'        => 'SERVICE_NUMBER',
            'serviceNumberTypes' => $type,
            'minPriceDollars'    => $minPrice,
            'maxPriceDollars'    => $maxPrice,
            'pageNum'            => $page,
            'pageSize'           => $limit,
            'sortBy'             => $sortBy,
            'sortDirection'      => $direction
        ]);

        // Add additional meta data
        foreach($result as &$number) {
            $number = $this->addAltFormats($number);
        }

        // Return the result
        return $result;
    }


    /**
     * Add additional formats to a number retrieved from the api
     * -------------------------------------------------------------------------
     * @param  stdClass  $number    A number retrieved from the api
     *
     * @return stdClass
     */
    protected function addAltFormats(\stdClass $number) : \stdClass
    {
        $number->format1 = preg_replace('|^(\d{4})(\d{6})$|i', '$1 $2', $number->number);
        $number->format2 = preg_replace('|^(\d{4})(\d{3})(\d{3})$|i', '$1 $2 $3', $number->number);
        $number->format3 = preg_replace('|^(\d{4})(\d{2})(\d{2})(\d{2})$|i', '$1 $2 $3 $4', $number->number);
        $number->format4 = (!empty($number->word) ? $number->word : $number->format3);
        return $number;
    }


    /**
     * Get all 1300 and 1800 numbers exposed by the API
     * -------------------------------------------------------------------------
     * @return stdClass[]
     */
    public function getAllNumbers()
    {
        $result = $this->getNumbers('1300', 'FLASH');
        $result = array_merge($result, $this->getNumbers('1300', 'LUCKY_DIP'));
        $result = array_merge($result, $this->getNumbers('1800', 'FLASH'));
        $result = array_merge($result, $this->getNumbers('1800', 'LUCKY_DIP'));

        // Return the result
        return $result;
    }

}
