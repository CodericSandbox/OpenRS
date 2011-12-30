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
 * Not_found controller class
 *
 * Displays a custom 404 not found page
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Not_found extends CI_Controller {

    /*
     * Not_found controller class constructor
     */

    function Not_found() {
	parent::__construct();
	$this->load->model('Category_model');
	$this->load->model('Review_model');
	$this->load->model('Ad_model');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function
     *
     * displays a 'not found' page
     * this replaces the default 404 page with one loaded from the current theme
     */

    function index() {
	debug('not found page | index function');
	// load data for view
	$data['message'] = lang('error_not_found');
	$data['meta_description'] = '';
	$data['meta_keywords'] = '';
	$data['page_title'] = lang('error_not_found_page_title');
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
	// display the not found page
	debug('loading "error/not_found" view');
	$sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/error/not_found', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/home/home_sidebar');
	$this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
    }

}

/* End of file not_found.php */
/* Location: ./application/controllers/not_found.php */