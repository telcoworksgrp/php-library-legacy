<?php
/**
 * =============================================================================
 * @package     Telcoworks Group PHP Library
 * @copyright   Copyright (c) 2020 Telcoworks Group. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @author      David Plath <webmaster@telcoworksgroup.com.au>
 * =============================================================================
 */

namespace TCorp\Legacy;

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


}
