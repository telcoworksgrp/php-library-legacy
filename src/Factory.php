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
 * Factory class for creating/getting objects
 */
class Factory
{

    /**
     * Holds the global Agent instance
     *
     * @var \TelcoworksGrp\Legacy\Agent
     */
    protected static $agent = null;


    /**
     * Holds the global Config instance
     *
     * @var \TelcoworksGrp\Legacy\Config
     */
    protected static $config = null;


    /**
     * Holds the global Email instance
     *
     * @var \TelcoworksGrp\Legacy\Email
     */
    protected static $email = null;


    /**
     * Holds the global Debugger instance
     *
     * @var \TelcoworksGrp\Legacy\Debugger
     */
    protected static $debugger = null;


    /**
     * Holds the global Firewall instance
     *
     * @var \TelcoworksGrp\Legacy\Firewall
     */
    protected static $firewall = null;


    /**
     * Holds the global Form instance
     *
     * @var \TelcoworksGrp\Legacy\Form
     */
    protected static $form = null;


    /**
     * Holds the global Input instance
     *
     * @var \TelcoworksGrp\Legacy\Input
     */
    protected static $input = null;


    /**
     * Holds the global Http instance
     *
     * @var \TelcoworksGrp\Legacy\Http
     */
    protected static $http = null;


    /**
     * Holds the global Log instance
     *
     * @var \TelcoworksGrp\Legacy\Log
     */
    protected static $log = null;


    /**
     * Holds the global Session instance
     *
     * @var \TelcoworksGrp\Legacy\Session
     */
    protected static $session = null;


    /**
     * Holds the global T3 Api instance
     *
     * @var \TelcoworksGrp\Legacy\T3Api
     */
    protected static $t3api = null;


    /**
     * Holds the global Web Api instance
     *
     * @var \TelcoworksGrp\Legacy\WebApi
     */
    protected static $webapi = null;




    /**
     * Get the global Agent instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Agent
     */
    public static function getAgent()
    {
        if (is_null(static::$agent)) {
            static::$agent = new Agent();
        }
        return static::$agent;
    }


    /**
     * Get the global Config instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Config
     */
    public static function getConfig()
    {
        if (is_null(static::$config)) {
            static::$config = new Config();
        }
        return static::$config;
    }


    /**
     * Get the global Email instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Email
     */
    public static function getEmail()
    {
        if (is_null(static::$email)) {
            static::$email = new Email(true);
        }
        return static::$email;
    }


    /**
     * Get the global Debugger instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Debugger
     */
    public static function getDebugger()
    {
        if (is_null(static::$debugger)) {
            static::$debugger = new Debugger();
        }
        return static::$debugger;
    }


    /**
     * Get the global Firewall instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Firewall
     */
    public static function getFirewall()
    {
        if (is_null(static::$firewall)) {
            static::$firewall = new Firewall();
        }
        return static::$firewall;
    }


    /**
     * Get the global Form instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Form
     */
    public static function getForm()
    {
        if (is_null(static::$form)) {
            static::$form = new Form();
        }
        return static::$form;
    }


    /**
     * Get the global Input instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Input
     */
    public static function getInput()
    {
        if (is_null(static::$input)) {
            static::$input = new Input();
        }
        return static::$input;
    }


    /**
     * Get the global Http instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Http
     */
    public static function getHttp()
    {
        if (is_null(static::$http)) {
            static::$http = new Http();
        }
        return static::$http;
    }


    /**
     * Get the global Log instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Log
     */
    public static function getLog()
    {
        if (is_null(static::$log)) {
            static::$log = new Log();
        }
        return static::$log;
    }


    /**
     * Get the global Session instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Session
     */
    public static function getSession()
    {
        if (is_null(static::$session)) {
            static::$session = new Session();
        }
        return static::$session;
    }


    /**
     * Get the global T3 Api instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\T3Api
     */
    public static function getT3Api()
    {
        if (is_null(static::$t3api)) {
            static::$t3api = new T3Api();
        }
        return static::$t3api;
    }


    /**
     * Get the global Web Api instance, creating it if necessary
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\WebApi
     */
    public static function getWebApi()
    {
        if (is_null(static::$webapi)) {
            static::$webapi = new WebApi();
        }
        return static::$webapi;
    }

}
