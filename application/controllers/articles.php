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
 * @license		OpenReviewScript is free software licensed under the GNU General Public License version 2 - This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
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
 * Articles controller class
 *
 * Displays a list of articles
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Articles extends CI_Controller {

    /*
     * Articles controller class constructor
     */

    function Articles() {
	parent::__construct();
	$this->load->model('Article_model');
	$this->load->model('Ad_model');
	$this->load->model('Review_model');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * index function
     *
     * display a list of articles
     */

    function index() {
	debug('articles page | index function');
	// set page_title, meta_keywords and meta_description
	$data['meta_description'] = lang('articles_meta_description') . ' - ' . $this->setting['site_name'] . ' - ' . strip_tags($this->setting['site_summary_title']) . ' - ' . strip_tags($this->setting['site_summary_text']);
	$data['meta_keywords'] = lang('articles_meta_keywords');
	$data['page_title'] = $this->setting['site_name'] . ' - ' . lang('article_page_title_articles');
	// load data for view
	$data['featured_count'] = $this->setting['featured_count'];
	$approval_required = $this->setting['review_approval'];
	$data['featured'] = $this->Review_model->getFeaturedReviews($data['featured_count'], 0, $approval_required);
	$data['featured_minimum'] = $this->setting['featured_minimum'];
	$data['featured_reviews'] = $this->setting['featured_section_article'] == 1 ? count($data['featured']) : 0;
	$data['sidebar_ads'] = $this->Ad_model->getAds($this->setting['max_ads_article_sidebar'], 3);
	$data['article_ads'] = $this->Ad_model->getAds($this->setting['max_ads_articles_lists'], 2);
	$data['show_recent'] = $this->setting['recent_review_sidebar'];
	$data['show_search'] = $this->setting['search_sidebar'];
	$approval_required = $this->setting['review_approval'];
	if ($data['show_recent'] == 1) {
	    $data['recent'] = $this->Review_model->getLatestReviews($this->setting['number_of_reviews_sidebar'], 0, $approval_required);
	} else {
	    $data['recent'] = FALSE;
	}
	$data['allarticles'] = $this->Article_model->getAllArticles($this->setting['perpage_site_articles'], $this->uri->segment(3));
	if ($data['allarticles']) {
	    debug('loaded list of articles');
	    // got list of articles
	    // set up config for pagination
	    $config['base_url'] = base_url() . 'articles/index';
	    $config['next_link'] = lang('results_next');
	    $config['prev_link'] = lang('results_previous');
	    $total = $this->Article_model->countArticles();
	    $config['total_rows'] = $total;
	    $config['per_page'] = $this->setting['perpage_site_articles'];
	    $config['uri_segment'] = 3;
	    $this->pagination->initialize($config);
	    $data['pagination'] = $this->pagination->create_links();
	    if (trim($data['pagination'] === '')) {
		$data['pagination'] = '&nbsp;<strong>1</strong>';
	    }
	    // display the list of articles
	    debug('loading "articles/article_content" view');
	    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/articles/articles_content', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/articles/articles_sidebar');
	    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
	} else {
	    // no data so display 'articles/no_articles' view
	    debug('no articles found');
	    $sections = array('content' => 'site/' . $this->setting['current_theme'] . '/template/articles/no_articles', 'sidebar' => 'site/' . $this->setting['current_theme'] . '/template/articles/articles_sidebar');
	    $this->template->load('site/' . $this->setting['current_theme'] . '/template/template', $sections, $data);
	}
    }

}

/* End of file articles.php */
/* Location: ./application/controllers/articles.php */