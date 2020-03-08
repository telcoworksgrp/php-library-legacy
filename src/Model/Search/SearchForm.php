
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


class SearchForm extends Model
{


    /**
     * Get the value of the search form's prefix field
     * -------------------------------------------------------------------------
     * @return int[]
     */
    public function getPrefix() : array
    {
        return Factory::getSession()->get('search.form.prefix', [1300,1800]);
    }


    /**
     * Check if a given prefix exists in the current prefix field. This is
     * handy for rendering checkboxes, radios, etc
     * -------------------------------------------------------------------------
     * @param  int  $prefix     The prefix too check
     *
     * @return bool
     */
    public function prefixExists(int $prefix) : bool
    {
        return in_array($prefix, $this->getPrefix());
    }


    /**
     * Set the value of the search form's prefix field
     * -------------------------------------------------------------------------
     * @param int[]     $value  A list of prefixes
     *
     * @return void
     */
    public function setPrefix(array $value) : void
    {
        Factory::getSession()->set('search.form.prefix', $value);
    }


    /**
     * Get the value of the search form's suffix field
     * -------------------------------------------------------------------------
     * @return string
     */
    public function getSuffix() : string
    {

        return Factory::getSession()->get('search.form.suffix', '');
    }


    /**
     * Set the value of the search form's suffix field
     * -------------------------------------------------------------------------
     * @param string    $value  A full/partial suffix
     *
     * @return void
     */
    public function setSuffix(string $value) : void
    {
        Factory::getSession()->set('search.form.suffix', $value);
    }


    /**
     * Update the search form's values from the curent request
     * -------------------------------------------------------------------------
     * @return void
     */
    public function updateFromRequest() : void
    {
        $input = Factory::getInput();

        if ($input->exists('prefix')) {
            $this->setPrefix($input->get('prefix'));
        }

        if ($input->exists('suffix')) {
            $this->setSuffix($input->get('suffix'));
        }
    }

}
