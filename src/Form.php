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
 * Class for working with HTML forms
 */
class Form
{

    /**
     * Gets HTML for rendering a hidden honeypot text field inside a web form
     * -------------------------------------------------------------------------
     * @return  string
     */
    public function getHoneypotHtml() : string
    {
        return '<input type="text" name="c67538" value="" ' .
            'style="display: none !important;">';
    }


    /**
     * Check if a honeypot is empty. If the honeypot has not been submitted or
     * contains a value then it is most likely a bot.
     * -------------------------------------------------------------------------
     * @return  bool
     */
    public function checkHoneypot() : bool
    {
        $value = Factory::getInput()->get('c67538', false);
        return $value !== false;
    }


    /**
     * Get the HTML/Javascript for displaying a reCAPTCHA 3
     * -------------------------------------------------------------------------
     * @return string
     */
    public function getReCaptchaHtml() : string
    {
        // Initialise some local variables
        $config = Factory::getConfig();
        $key    = $config->get('form.recaptcha.sitekey', '');

        // Compose some HTML
        $result  = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>\n";
        $result .= "<div class=\"g-recaptcha\" data-sitekey=\"$key\"></div>";

        // Return the result
        return $result;
    }


    /**
     * Check if the user was successfully completed a reCAPTCHA 3
     * -------------------------------------------------------------------------
     * @param  string   $secretKey    reCAPTCHA Secret Key (issued by Google)
     *
     * @return  bool
     */
    public function checkReCaptcha() : bool
    {
        // Initialise some local variables
        $input    = Factory::getInput();
        $config   = Factory::getConfig();
        $response = $input->post('g-recaptcha-response', '');
        $key      = $config->get('form.recaptcha.secret', '');

        // Send http request to verify the response with Google
        $uri = 'https://www.google.com/recaptcha/api/siteverify';
        $response = Factory::getHttp()->post($uri, [
            'form_params' => ['secret' => $key, 'response' => $response],
            'http_errors' => true
        ]);

        // Parse the response
        $result = json_decode($response->getBody());

        // Return the result
        return $result->success == true;
    }


    /**
     * Get a CSRF token that can used to protect the site from XSS attacks
     * -------------------------------------------------------------------------
     * @return string
     */
    public function getCsrfToken() : string
    {
        // Initialise some local variables
        $session = Factory::getSession();

        // Set the token if none alreasy exists
        if (!$session->has('csrf')) {
            $session->set('csrf', bin2hex(random_bytes(32)));
        }

        // Return the result
        return $session->get('csrf', '');
    }



    /**
     * Gets HTML for rendering a CSRF token inside a web form
     * -------------------------------------------------------------------------
     * @return string
     */
    public function getCsrfTokenHTML() : string
    {
        // Get a CSRF token
        $token = $this->getCsrfToken();

        // Compose a HTML input form field
        $result = "<input type=\"hidden\" name=\"csrf\" value=\"$token\">";

        // Return the result
        return $result;
    }


    /**
     * Check if the CSRF token in the POST params is valid (the same as the
     * one previously set in the session)
     * -------------------------------------------------------------------------
     * @return  bool
     */
    public function checkCsrfToken() : bool
    {
        // Initialise some local variables
        $session = Factory::getSession();
        $input   = Factory::getInput();

        // Get the token submited in the post request
        $token = $input->get('csrf', '');

        // Check if the token is valid
        $result = hash_equals($this->getCsrfToken(), $token);

        // Return the result
        return $result;
    }

}
