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
 * Class for debugging the application/website
 */
class Debugger
{

    /**
	 * Enable all PHP error and warning messages
	 * ------------------------------------------------------------------------
	 * @return void
	 */
    public function enable() : void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }


    /**
     * Suppress all PHP error and warning messages
     * -------------------------------------------------------------------------
     * @return void
     */
    public function suppress() : void
    {
        error_reporting(0);
        ini_set('display_errors', 0);
    }


    /**
     * Dump the contents of variable
     * -------------------------------------------------------------------------
     * @param  mixed    $var    Variable to dump
     *
     * @return void
     */
    public function dump($var) : void
    {
        print_r($var);
    }


    /**
     * Dump the contents of variable and then die
     * -------------------------------------------------------------------------
     * @param  mixed    $var    Variable to dump
     *
     * @return void
     */
    public function dd($var) : void
    {
        $this->dump($var);
        die();
    }

}
