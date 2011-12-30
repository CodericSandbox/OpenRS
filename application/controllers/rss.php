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
 * Rss controller class
 *
 * Outputs RSS feed with latest reviews
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Rss extends CI_Controller {

    /*
     * Rss controller class constructor
     */

    function Rss() {
	parent::__construct();
	$this->load->model('Review_model');
	$this->load->model('Article_model');
	$this->load->helper('xml');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function (default)
     *
     * output rss feed
     */

    function index() {
	debug('rss page | index function');
	// get data for rss feed
	$data['encoding'] = 'utf-8';
	$data['title'] = $this->setting['site_name'];
	$data['link'] = base_url() . '/rss';
	$data['description'] = lang('rss_description');
	$data['language'] = 'en';
	$data['creator'] = $this->setting['site_name'];
	$data['owner'] = $this->setting['site_email'];
	$approval_required = $this->setting['review_approval'];
	$data['reviews'] = $this->Review_model->getLatestReviews(200, 0, $approval_required);
	$data['articles'] = $this->Article_model->getAllArticles(200);
	header('Content-Type: application/rss+xml');
	debug('loading "rss/rss_template" view');
	$sections = array('rss_content' => 'site/' . $this->setting['current_theme'] . '/template/rss/rss');
	$this->template->load('site/' . $this->setting['current_theme'] . '/template/rss/rss_template', $sections, $data);
    }

}

/* End of file rss.php */
/* Location: ./application/controllers/rss.php */