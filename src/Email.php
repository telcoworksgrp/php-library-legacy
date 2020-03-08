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


use PHPMailer\PHPMailer\PHPMailer;


/**
 * Class for sending emails
 */
class Email extends PHPMailer
{


    /**
     * Set the email's subject line
     * -------------------------------------------------------------------------
     * @param  string   $subject    An email subject line
     *
     * @return \TelcoworksGrp\Legacy\Email
     */
    public function setSubject(string $subject) : Email
    {
        $this->Subject = $subject;
        return $this;
    }


    /**
     * Setthe email's body content. The email format will automatically be
     * set to HTML if tags are found in the given body
     * -------------------------------------------------------------------------
     * @param  string   $body   The email's body
     *
     * @return Email
     */
    public function setBody(string $body) : Email
    {
        $this->Body = $body;
        $this->isHTML($body != strip_tags($body));
        return $this;
    }


    /**
     * Start capturing the PHP output
     * -------------------------------------------------------------------------
     * @return void
     */
    public function startCapture()
    {
        ob_start();
    }


    /**
     * Stop capturing the PHP output and set the email body
     * -------------------------------------------------------------------------
     * @return \TelcoworksGrp\Legacy\Email
     */
    public function endCapture()
    {
        return $this->setBody(ob_get_clean());
    }


    /**
     * Clear all addresses, attchments, etc
     * -------------------------------------------------------------------------
     * @return void
     */
    public function clear()
    {
        $this->clearAllRecipients();
        $this->clearReplyTos();
        $this->clearAttachments();
        $this->clearCustomHeaders();
        $this->setSubject('');
        $this->setBody('');
    }

}
