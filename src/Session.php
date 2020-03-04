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

use Joomla\Session\Session AS JSession;


/**
 * Class for working with the current session
 */
class Session extends JSession
{


    /**
     * Constructor for initialising new instances of this class
     * -------------------------------------------------------------------------
     * @param string    $store      The type of storage for the session.
     * @param array     $options    Optional parameters
     *
     * @return void
     */
    public function __construct($store = 'none', array $options = array())
	{
        // Call the parent method
        parent::__construct($store, $options);

        // Initialise some additional parent class properties
        $this->initialise(Factory::getInput());
    }


    /**
     * Set or replace a session value using a given input variable
     * -------------------------------------------------------------------------
     * @param string    $key        Dot seperated key name
     * @param string    $var        Input variable name
     * @param mixed     $default    Value to set if no input or session value
     * @param string    $filter     Filter to appy to the input value
     *
     * @return mixed
     */
    public function setFromRequst(string $key, string $var, $default,
        string $filter = 'string')
    {
        // Initialise some local variables
        $input = Factory::getInput();

        // Get value from input, session or a given default value
        $value = $input->get($var, $this->get($key, $default), $filter);

        // Update the session
        $this->set($key, $value);

        // Return the final value
        return $value;
    }


}
