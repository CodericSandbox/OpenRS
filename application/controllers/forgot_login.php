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
 * Forgot_login controller class
 *
 * Sends an email with a link to the reset password page
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Forgot_login extends CI_Controller {

    /*
     * Forgot_login controller class constructor
     */

    function Forgot_login() {
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
     * index function (default)
     *
     * display forgot login form
     */

    function index() {
	debug('forgot_login page | index function');
	// check user is not already logged in
	if (!$this->secure->isLoggedIn($this->session)) {
	    debug('user is not already logged in');
	    // load data for view
	    $data['page_title'] = $this->setting['site_name'] . ' - ' . lang('site_register_forgot_login_title');
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
	    // check form was submitted
	    if ($this->input->post('login_forgot_submit')) {
		// set up form validation config
		debug('form was submitted');
		$config = array(
		    array(
			'field' => 'login_email',
			'label' => lang('site_login_forgot_validation_email'),
			'rules' => 'trim|required|xss_clean'
		    )
		);
		$this->form_validation->set_error_delimiters('<br><span class="error">', '</span>');
		$this->form_validation->set_rules($config);
		debug('validate form data');
		// validate the form data
		if ($this->form_validation->run() === FALSE) {
		    // validation failed - reload page with error message(s)
		    debug('validation failed - loading "forgot_login" view');
		    $data['message'] = '';
		    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/forgot_login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
		    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		} else {
		    // validation successful
		    debug('validation successful');
		    // check email address belongs to a user
		    $user_id = $this->User_model->userEmailExists($this->input->post('login_email'));
		    if ($user_id) {
			debug('user\'s email address exists');
			// store a temporary key in the user record
			$temporary_key = $this->User_model->storeTemporaryKey($user_id);
			// create the email message
			$user = $this->User_model->getUserById($user_id);
			$email_message = lang('site_login_forgot_email_message_1a') . $this->setting['site_name'] . "\n\n";
			$email_message .= lang('site_login_forgot_email_message_1b') . $user->name . "\n\n";
			$email_message .= lang('site_login_forgot_email_message_1c') . "\n\n";
			$email_message .= lang('site_login_forgot_email_message_1d') . "\n\n";
			// include a link with the key so we can identify the user when they confirm the password reset request
			$email_message .= base_url() . 'reset_password/do_reset/' . urlencode($temporary_key);
			$this->email->from($this->setting['site_email']);
			$this->email->to($this->input->post('login_email'));
			$this->email->subject(lang('site_login_forgot_password_reset_subject') . $this->setting['site_name']);
			$this->email->message($email_message);
			// send the email
			debug('send the email to the user');
			if ($this->email->send()) {
			    // email sent... display the 'login sent' page
			    $data[] = '';
			    debug('loading "login_sent" view');
			    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/login_sent', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
			    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
			} else {
			    debug('email not sent - show error');
			    show_error(lang('error_sending_email'));
			    exit;
			}
		    } else {
			// if email address not found reload the page with a message informing the user
			$data['message'] = lang('site_login_forgot_no_user');
			debug('email address not found - loading "forgot_login" view');
			$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/forgot_login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
			$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		    }
		}
	    } else {
		// form not submitted so just show the form
		$data['message'] = '';
		debug('form not submitted - loading "forgot_login" view');
		$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/forgot_login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
		$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
	    }
	} else {
	    // user is already logged in so redirect to home page
	    debug('user is already logged in - redirecting to "home"');
	    redirect('/home', 301);
	}
    }

}

/* End of file forgot_login.php */
/* Location: ./application/controllers/forgot_login.php */