<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 * This file is based on the original CodeIgniter Exceptions.php file
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
/**    This file is part of OpenReviewScript.
 *
 *    OpenReviewScript is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    OpenReviewScript is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OpenReviewScript.  If not, see <http://www.gnu.org/licenses/>.
 */
class MY_Exceptions extends CI_Exceptions {

    var $CI;

    function MY_Exceptions() {
	parent::__construct();
    }

    function show_404($page='') {
	if (isset($log_error)) {
	    if ($log_error)
		log_message('error', '404 Page Not Found --> ' . $page);
	}
	$this->config = & get_config();
	$base_url = $this->config['base_url'];
	header("location: " . $base_url . "not_found");
	exit;
    }

    function show_error($heading, $message, $template = 'error_general', $status_code = 500) {
	$this->config = & get_config();
	$base_url = $this->config['base_url'];
	$errors = array('error_message' => lang('error_message') . $message);
	$CI = & get_instance();
	$CI->load->library('session');
	//If something really bad has happened like a failed database connection
	//show the error directly. If we didn't do this, we would get a PHP error
	//saying we're trying to access a non-object.
	if (!is_object($CI->session)) {
	    if (is_array($message)) {
		foreach ($message as $item) {
		    echo $item . "<br />";
		}
	    } else {
		echo $message . "<br />";
	    }
	    die ();
	}
	//Store the errors in the session
	$CI->session->set_userdata($errors);
	header("location: " . $base_url . "error");
    }

}