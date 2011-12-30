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
 * Login controller class
 *
 * Displays login form and allows or denies manager access
 *
 * @package		OpenReviewScript
 * @subpackage          manager
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
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function (default)
     *
     * display/process login form
     */

    function index() {
	debug('manager/login page | index function');
	$data['message'] = '';
	// check manager is not already logged in
	if (!$this->secure->isManagerLoggedIn($this->session)) {
	    debug('manager is not already logged in');
	    // check form was submitted
	    if ($this->input->post('login_submit')) {
		debug('form was submitted');
		// delete username session variable
		$this->session->unset_userdata('username');
		// set up form validation config
		$config = array(
		    array(
			'field' => 'login_username',
			'label' => lang('manager_login_form_validation_username'),
			'rules' => 'trim|required|xss_clean'
		    ),
		    array(
			'field' => 'login_password',
			'label' => lang('manager_login_form_validation_password'),
			'rules' => 'trim|required|xss_clean'
		    )
		);
		$this->form_validation->set_error_delimiters('<br><span class="error">', '</span>');
		$this->form_validation->set_rules($config);
		debug('validate form data');
		// get 'last_page' session variable... this is stored when user tries to access a manager page, then we can redirect them after logging in
		$last_page = $this->session->userdata('last_page');
		// validate the form data
		if ($this->form_validation->run() === FALSE) {
		    // validation failed - reload page with error message(s)
		    debug('validation failed - loading "manager/login" view');
		    $sections = array('content' => 'manager/' . $this->setting['current_manager_theme'] . '/template/login/login');
		    $this->template->load('manager/' . $this->setting['current_manager_theme'] . '/template/manager_template', $sections, $data);
		} else {
		    // validation successful
		    debug('validation successful - logging user in');
		    if ($this->simplelogin->login($this->input->post('login_username'), $this->input->post('login_password'), 10)) {
			// log in successful
			debug('log in successful');
			// clear 'last_page' session variable
			$this->session->unset_userdata('last_page');
			if (trim($last_page) !== '') {
			    // if a url was stored, redirect to it now
				debug('redirect user to previously visited page... '.$last_page);
			    redirect($last_page, 301);
			}
			// no stored url so redirect to manager home page
			debug('no stored previous page url - redirecting to "manager/home"');
			redirect('/manager/home');
		    } else {
			// log in failed, reload page with message
			$data['message'] = lang('manager_login_fail');
			debug('log in failed - loading "manager/login" view');
			$sections = array('content' => 'manager/' . $this->setting['current_manager_theme'] . '/template/login/login');
			$this->template->load('manager/' . $this->setting['current_manager_theme'] . '/template/manager_template', $sections, $data);
		    }
		}
	    } else {
		// form was not submitted so just show the form
		$data['message'] = '';
		debug('form was not submitted - loading "manager/login" view');
		$sections = array('content' => 'manager/' . $this->setting['current_manager_theme'] . '/template/login/login');
		$this->template->load('manager/' . $this->setting['current_manager_theme'] . '/template/manager_template', $sections, $data);
	    }
	} else {
	    // manager is already logged in so redirect to manager home page
	    debug('manager is already logged in - redirecting to "manager/home"');
	    redirect('/manager/home', 301);
	}
    }

}

/* End of file login.php */
/* Location: ./application/controllers/manager/login.php */