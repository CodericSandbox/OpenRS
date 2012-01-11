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
 * Reset_password controller class
 *
 * Allows user to reset password
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Reset_password extends CI_Controller {

    /*
     * Forgot_login controller class constructor
     */

    function Reset_password() {
	parent::__construct();
	$this->load->library('form_validation');
	$this->load->model('User_model');
	$this->load->library('email');
	$this->load->helper('form');
	$this->load->model('Review_model');
	$this->load->model('Ad_model');
	$this->load->model('Category_model');	
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * do_reset function
     *
     * check the provided key, reset the password and send an email to the user
     */

    function do_reset($key) {
	debug('reset_password page | do_reset function');
	// load data for view
	$data['page_title'] = $this->setting['site_name'] . ' - ' . lang('site_register_reset_password_title');
	$data['sidebar_ads'] = $this->Ad_model->getAds($this->setting['max_ads_home_sidebar'], 3);
	$data['show_recent'] = $this->setting['recent_review_sidebar'];
	$data['show_search'] = $this->setting['search_sidebar'];
	$data['categories'] = $this->Category_model->getAllCategories(0);
	$data['show_categories'] = $this->setting['categories_sidebar'];
	$data['captcha_verification'] = $this->setting['captcha_verification'];
	$data['keywords'] = '';
	$approval_required = $this->setting['review_approval'];
	if ($data['show_recent'] == 1) {
	    $data['recent'] = $this->Review_model->getLatestReviews($this->setting['number_of_reviews_sidebar'], 0, $approval_required);
	} else {
	    $data['recent'] = FALSE;
	}
	if ($this->setting['tag_cloud_sidebar'] > 0) {
	    //Prepare Tag Cloud
	    $tagcloud = $this->Review_model->getTagCloudArray();
	    if ($tagcloud !== FALSE) {
		$data['tagcloud'] = $tagcloud;
		foreach ($data['tagcloud'] as $tagkey => $value) {
		    $tagcount[$tagkey] = $value[0];
		}
		$data['cloudmax'] = max($tagcount);
		$data['cloudmin'] = min($tagcount);
	    }
	}
	// check key was provided
	if ($key !== '') {
	    // use key to find the user's email address
	    $user_email = $this->User_model->getEmailFromKey($key);
	    if ($user_email) {
		debug('found user\'s email address using key');
		// create a new password for the user
		$newPassword = $this->User_model->resetPassword($key);
		if ($newPassword) {
		    debug('created new password');
		    // send email to the user with the new password
		    $email_message = lang('site_login_forgot_email_message_2a') . "\n\n";
		    $email_message .= $newPassword . "\n\n";
		    $email_message .= lang('site_login_forgot_email_message_2b') . ' ' . base_url() . 'login';
		    $this->email->from($this->setting['site_email']);
		    $this->email->to($user_email);
		    $this->email->subject(lang('site_login_forgot_new_password_subject'));
		    $this->email->message($email_message);
		    debug('sending email message to user');
		    if ($this->email->send()) {
			// email sent... display the 'password reset' page
			$data[] = '';
			debug('loading "password_reset" view');
			$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/password_reset', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
			$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		    } else {
			debug('error sending email (server error)');
			show_error(lang('error_sending_email'));
			exit;
		    }
		} else {
		    // problem creating password - redirect to
		    debug('problem creating new password - show error');
		    show_error(lang('error_creating_password'));
		    exit;
		}
	    } else {
		// email not found - redirect to log in page
		debug('email addresss not found - redirecting to "home"');
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
/* Location: ./application/controllers/manager/reset_password.php */