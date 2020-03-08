
<?php
/**
 * =============================================================================
 * @package     Telcoworks Group PHP Library
 * @copyright   Copyright (c) 2020 Telcoworks Group. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @author      David Plath <webmaster@telcoworksgroup.com.au>
 * =============================================================================
 */

namespace TelcoworksGrp\Legacy\Model\Search;


use \TelcoworksGrp\Legacy\Model;
use \TelcoworksGrp\Legacy\Factory;


class SearchResults extends Model
{


    /**
     * Get a list of search results from the WebAPI
     * -------------------------------------------------------------------------
     * @return mixed
     */
    public function getResults()
    {
        // Initialise some local variables
        $webapi = Factory::getWebApi();

        // Get the current state of the search form
        $searchForm = new SearchForm();
        $prefix = $searchForm->getPrefix();
        $suffix = $searchForm->getSuffix();

        // Only lookup full suffixes
        if (strlen($suffix) < 6) {
            return false;
        }

        // Look up number in the web api
        $result = $webapi->getNumbers($prefix, $suffix);

        // Return the results
        return $result;
    }


    /**
     * Get a list of search suggestions from the WebAPI
     * -------------------------------------------------------------------------
     * @return mixed
     */
    public function getSuggestions()
    {
        // Initialise some local variables
        $webapi = Factory::getWebApi();

        // Get the current state of the search form
        $searchForm = new SearchForm();
        $prefix = $searchForm->getPrefix();
        $suffix = $searchForm->getSuffix();

        // Look up number in the web api
        $result = $webapi->getSuggestions($prefix, $suffix);

        // Return the results
        return $result;
    }



}
