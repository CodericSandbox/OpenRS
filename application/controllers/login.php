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
 * Login controller class
 *
 * Displays login form and allows or denies user access
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Login extends CI_Controller {

    /*
     * Login controller class constructor
     */

    function Login() {
	parent::__construct();
	$this->load->library('form_validation');
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
     * display/process login form
     */

    function index() {
	debug('login page | index function');
	$data['message'] = '';
	// check user is not already logged in
	if (!$this->secure->isLoggedIn($this->session)) {
	    debug('user is not already logged in');

	    $data['page_title'] = $this->setting['site_name'] . ' - ' . lang('site_login_page_title');
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
	    if ($this->input->post('login_submit')) {
		debug('form was submitted');
		// delete username session variable
		$this->session->unset_userdata('username');
		// set up form validation config
		$config = array(
		    array(
			'field' => 'login_username',
			'label' => lang('site_login_form_validation_username'),
			'rules' => 'trim|required|xss_clean'
		    ),
		    array(
			'field' => 'login_password',
			'label' => lang('site_login_form_validation_password'),
			'rules' => 'trim|required|xss_clean'
		    )
		);
		$this->form_validation->set_error_delimiters('<br><span class="error">', '</span>');
		$this->form_validation->set_rules($config);
		debug('validate form data');
		// get 'last_page' session variable... this is stored when user tries to access a page that requires login, then we can redirect them after logging in
		$last_page = $this->session->userdata('last_page');
		// validate the form data
		if ($this->form_validation->run() === FALSE) {
		    // validation failed - reload page with error message(s)
		    debug('validation failed - loading "login" view');
		    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/login/login_sidebar');
		    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		} else {
		    // validation successful
		    debug('validation successful - logging user in');
		    if ($this->simplelogin->login($this->input->post('login_username'), $this->input->post('login_password'), 1)) {
			// log in successful
			debug('log in successful');
			// clear 'last_page' session variable
			$this->session->unset_userdata('last_page');
			if (trim($last_page) !== '') {
			    // if a url was stored, redirect to it now
				debug('redirect user to previously visited page... '.$last_page);
			    redirect($last_page, 301);
			}
			// no stored url so redirect to home page
			debug('no stored previous page url - redirecting to "home"');
			redirect('/home');
		    } else {
			// log in failed, reload page with message
			$data['message'] = lang('site_login_fail');
			debug('log in failed - loading "login" view');
			$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/login/login_sidebar');
			$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
		    }
		}
	    } else {
		// form was not submitted so just show the form
		$data['message'] = '';
		debug('form was not submitted - loading "login" view');
		$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/login/login', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/login/login_sidebar');
		$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
	    }
	} else {
	    // user is already logged in so redirect to home page
	    debug('user is already logged in - redirecting to "home"');
	    redirect('/home', 301);
	}
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */