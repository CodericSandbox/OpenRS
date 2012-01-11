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
 * Register controller class
 *
 * Displays registration form and allows or denies user access
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Register extends CI_Controller {

    /*
     * Register controller class constructor
     */

    function Register() {
	parent::__construct();
	$this->load->library('form_validation');
	$this->load->helper('form');
	$this->load->model('Review_model');
	$this->load->model('Ad_model');
	$this->load->model('Category_model');
	$this->load->model('User_model');
	$this->load->library('email');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function (default)
     *
     * display/process registration form
     */

    function index() {
	debug('register page | index function');
	$data['message'] = '';
	// check user is not already logged in
	if (!$this->secure->isLoggedIn($this->session)) {
	    debug('user is not already logged in');

	    $data['page_title'] = $this->setting['site_name'] . ' - ' . lang('site_register_page_title');
	    // load data for view
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
		    foreach ($data['tagcloud'] as $key => $value) {
			$tagcount[$key] = $value[0];
		    }
		    $data['cloudmax'] = max($tagcount);
		    $data['cloudmin'] = min($tagcount);
		}
	    }


	    // check form was submitted
	    if ($this->input->post('register_submit')) {
		debug('form was submitted');
		// delete username session variable
		$this->session->unset_userdata('username');
		// set up form validation config
		$config = array(
		    array(
			'field' => 'register_username',
			'label' => lang('manager_user_form_validation_name'),
			'rules' => 'trim|alpha_numeric|required|min_length[4]|max_length[15]|xss_clean'
		    ),
		    array(
			'field' => 'register_password',
			'label' => lang('manager_user_form_validation_password'),
			'rules' => 'alpha_numeric|required|min_length[6]|max_length[15]|xss_clean'
		    ),
		    array(
			'field' => 'register_email',
			'label' => lang('manager_user_form_validation_email'),
			'rules' => 'trim|required|valid_email|min_length[5]|max_length[255]|xss_clean'
		    )
		);
		$this->form_validation->set_error_delimiters('<br><span class="error">', '</span>');
		$this->form_validation->set_rules($config);
		debug('validate form data');
		// validate the form data
		if ($this->form_validation->run() === FALSE) {
		    // validation failed - reload page with error message(s)
		    debug('validation failed - loading "register" view');
		    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
		    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		} else {
		    // validation successful
		    debug('validation successful - registering user');
		    // register the user



		    // check username does not exist
		    $user_exists = $this->User_model->getUserByName(trim($this->input->post('register_username')));
		    if (!$user_exists) {
			// check email does not exist
			$email_exists = $this->User_model->userEmailExists($this->input->post('register_email'));
			if (!$email_exists) {
			    // prepare data for adding to database
			    $name = $this->input->post('register_username');
			    $password = $this->input->post('register_password');
			    $email = $this->input->post('register_email');
			    $level = 1;
			    // check if new users require activation
			    if ($this->setting['members_activation']=='1') {
				// add the user as inactive
				$new_user_id = $this->User_model->addUser($name, $password, $email, $level, 0);
				// store a temporary key in the user record
				$temporary_key = $this->User_model->storeTemporaryKey($new_user_id);
				// create the email message
				$user = $this->User_model->getUserById($new_user_id);
				$email_message = lang('site_register_email_message_1a') . $this->setting['site_name'] . "\n\n";
				$email_message .= lang('site_register_email_message_1b') . $user->name . "\n\n";
				$email_message .= lang('site_register_email_message_1c') . "\n\n";
				$email_message .= lang('site_register_email_message_1d') . "\n\n";
				// include a link with the key so we can identify the user when they confirm their registration
				$email_message .= base_url() . 'activate/' . urlencode($temporary_key);
				$this->email->from($this->setting['site_email']);
				$this->email->to($this->input->post('register_email'));
				$this->email->subject(lang('site_register_activate_subject') . $this->setting['site_name']);
				$this->email->message($email_message);
				// send the email
				debug('send the email to the user');
				if ($this->email->send()) {
				    // email sent... display the 'login sent' page
				    $data['message'] = lang('site_user_add_success');
				    // display the form
				    debug('loading "register" view');
				    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
				    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
				} else {
				    debug('email not sent - show error');
				    show_error(lang('error_sending_email'));
				    exit;
				}
			    }
			    else
			    {
				// add the user as active
				$new_user_id = $this->User_model->addUser($name, $password, $email, $level, 1);
				$data['message'] = lang('site_user_add_success');
				// display the form
				debug('loading "register" view');
				$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
				$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
				
			    }
			} else {
			    // email address already exists - reload page and display error
			    $data['message'] = lang('site_user_form_email_exists');
			    debug('email address already exists - loading "register" view');
			    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
			    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
			}
		    } else {
			// username already exists, reload page with error message
			$data['message'] = lang('site_user_form_username_exists');
			debug('username already exists - loading "register" view');
			$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
			$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		    }



		}
	    } else {
		// form was not submitted so just show the form
		$data['message'] = '';
		debug('form was not submitted - loading "register" view');
		$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/register/register', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/register/register_sidebar');
		$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
	    }
	} else {
	    // user is already logged in so redirect to home page
	    debug('user is already logged in - redirecting to "home"');
	    redirect('/home', 301);
	}
    }

}

/* End of file register.php */
/* Location: ./application/controllers/register.php */