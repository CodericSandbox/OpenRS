<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          manager
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011, OpenReviewScript.org
 * @license		This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 * @link		http://OpenReviewScript.org
 */
// ------------------------------------------------------------------------

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

/**
 * Activate controller class
 *
 * Activates a user's account when they click the link in their activation email
 *
 * @package		OpenReviewScript
 * @subpackage          manager
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Activate extends CI_Controller {

    /*
     * Forgot_login controller class constructor
     */

    function Reset_password() {
	parent::__construct();
	$this->load->model('User_model');
	$this->load->library('email');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * do_reset function
     *
     * check the provided key, reset the password and send an email to the user
     */

    function do_activation($key) {
	debug('activate page | index function');
	// check key was provided
	if ($key !== '') {
	    // use key to find the user's email address
	    $user_email = $this->User_model->getEmailFromKey($key);
	    if ($user_email) {
		debug('found user\'s email address using key');
		debug('activating user\'s account');
		$activated = $this->User_model->activateAccount($key);
		if ($activated === TRUE) {{}
		    // send email to the user with the new password
		    $email_message = lang('site_register_activated_message_2a') . "\n\n";
		    $email_message .= lang('site_register_activated_message_2b') . ' ' . base_url() . 'login';
		    $this->email->from($this->setting['site_email']);
		    $this->email->to($user_email);
		    $this->email->subject(lang('site_register_activated_subject') . $this->setting['site_name']);
		    $this->email->message($email_message);
		    debug('sending email message to user');
		    if ($this->email->send()) {
			// email sent... display the 'activated' page
			$data[] = '';
			debug('loading "activated" view');
			$sections = array('content' => 'site/' . $this->setting['current_site_theme'] . '/template/activate/activated');
			$this->template->load('site/' . $this->setting['current_site_theme'] . '/template/site_template', $sections, $data);
		    } else {
			debug('error sending email (server error)');
			show_error(lang('error_sending_email'));
			exit;
		    }
		}
	    } else {
		// email not found - redirect to log in page
		debug('user account not found - redirecting to "home"');
		redirect('/home', '301');
	    }
	} else {
	    // no key - redirect to log in page
	    debug('no key provided - redirecting to "home"');
	    redirect('/home', '301');
	}
    }

}

/* End of file reset_password.php */
/* Location: ./application/controllers/activate.php */