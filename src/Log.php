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


 use \Monolog\Logger;
 use \Monolog\Handler\StreamHandler;
 use \Monolog\Processor\WebProcessor;
 use \Monolog\Formatter\LineFormatter;


 /**
  * Class for logging events/messages to file
  */
  class Log extends Logger
  {

      /**
       * Format for each row in the log file
       *
       * @var string
       */
      protected $format = "[%datetime%]\t%level_name%\t%message%\t%extra%\n";


      /**
       * Filename of the log file
       *
       * @var string
       */
      protected $filename = "legacy.log";



      /**
       * Constructor for initialising new instances of this class
       * ------------------------------------------------------------------------
       */
      public function __construct(string $name, array $handlers = [],
        array $processors = [], ?DateTimeZone $timezone = null)
      {
        // Call the parent constructor
        parent::__construct($name, $handlers, $processors, $timezone);

         // Add a file stream handler
         $handler = new StreamHandler("{$_SERVER['DOCUMENT_ROOT']}/{$this->filename}");
         $handler->setFormatter(new LineFormatter($this->format));
         $this->pushHandler($handler);

         // Add a custom log processor
         $this->pushProcessor(function($record) {
             $record['extra']['sessionid'] = session_id();
             return $record;
         });

         // Add a web processor
         $processor = new WebProcessor();
         $this->pushProcessor($processor);
      }


  }
