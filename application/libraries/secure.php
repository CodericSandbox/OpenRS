<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011, OpenReviewScript.org
 * @license		This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 * @link		http://OpenReviewScript.org
 */
// ------------------------------------------------------------------------
//
/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011, OpenReviewScript.org
 * @license		This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 * @link		http://OpenReviewScript.org
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Secure {

    function allowManagers($session) {
	//Check user is logged and user level is manager
	if (!$session->userdata('logged_in') OR ($session->userdata('level') < 10)) {
	    //Store current url, after the users logs in we can redirect them to the page they wanted
	    $session->set_userdata('last_page', current_url());
	    //Redirect to log in page for manager
	    redirect('/manager/login', 301);
	}
    }

    function isManagerLoggedIn($session) {
	if (($session->userdata('logged_in') && ($session->userdata('level') >= 10))) {
	    return true;
	} else {
	    return false;
	}
    }
    function isLoggedIn($session) {
	if (($session->userdata('logged_in'))) {
	    return true;
	} else {
	    return false;
	}
    }

}

/* End of file secure.php */
/* Location: ./application/libraries/secure.php */