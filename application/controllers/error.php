<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011-2012, OpenReviewScript.org
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
 * Error controller class
 *
 * Displays custom error page
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Error extends CI_Controller {

    /*
     * Error controller class constructor
     */

    function Error() {
	parent::__construct();
	$this->load->model('Category_model');
	$this->load->model('Review_model');
	$this->load->model('Ad_model');
	$this->load->library('session');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function
     *
     * display a custom error page
     */

    function index() {
	debug('error page | index function');
	// check an error message has been stored in a session variable
	if (trim($this->session->userdata('error_message')) !== '') {
	    // store message and unset session variable
	    $data['message'] = $this->session->userdata('error_message');
	    $this->session->unset_userdata('error_message');
	    debug('error message is "' . $data['message'] . '"');
	} else {
	    // no error message so redirect to home page
	    debug('no error message - redirecting to home page');
	    header("location: " . base_url());
	    exit;
	}
	// set the page title, meta keywords and meta description
	$data['page_title'] = lang('error_page_title');
	$data['meta_description'] = '';
	$data['meta_keywords'] = '';
	$data['show_categories'] = $this->setting['categories_sidebar'];
	$data['show_search'] = $this->setting['search_sidebar'];
	$data['show_recent'] = $this->setting['recent_review_sidebar'];
	$approval_required = $this->setting['review_approval'];
	if ($data['show_recent'] == 1) {
	    $data['recent'] = $this->Review_model->getLatestReviews($this->setting['number_of_reviews_sidebar'], 0, $approval_required);
	} else {
	    $data['recent'] = FALSE;
	}
	$data['categories'] = $this->Category_model->getAllCategories(0);
	$data['sidebar_ads'] = $this->Ad_model->getAds($this->setting['max_ads_home_sidebar'], 3);
	if ($data['sidebar_ads']) {
	    foreach ($data['sidebar_ads'] as $ad) {
		if (trim($ad->local_image_name !== '')) {
		    $ad->image = '<img src="' . base_url() . 'uploads/ads/images/' . $ad->local_image_name . '" width="' . (($ad->image_width > 0) ? $ad->image_width : 100) . '" height="' . (($ad->image_height > 0) ? $ad->image_height : 80) . '"/>';
		} else {
		    if (trim($ad->remote_image_url !== '')) {
			$ad->image = '<img src="' . $ad->remote_image_url . '" width="' . (($ad->image_width > 0) ? $ad->image_width : 100) . '" height="' . (($ad->image_height > 0) ? $ad->image_height : 80) . '"/>';
		    } else {
			$ad->image = '';
		    }
		}
	    }
	}
	// show the error page
	debug('loading "error/error" view');
	$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/error/error', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
	$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
    }

}

/* End of file error.php */
/* Location: ./application/controllers/error.php */