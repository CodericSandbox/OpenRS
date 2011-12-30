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
 * Recommends controller class
 *
 * Allows use of seo friendly links that hide the affiliate link
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            controller
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Recommends extends CI_Controller {

    /*
     * Recommends controller class constructor
     */

    function Recommends() {
	parent::__construct();
	$this->load->model('Review_model');
	// load all settings into an array
	$this->setting = $this->Setting_model->getEverySetting();
    }

    /*
     * this function
     *
     * get the review and redirect to the external link
     */

    function this($seo_title) {
	debug('recommends page | this function');
	// load the review
	$review = $this->Review_model->getReviewBySeoTitle($seo_title);
	// get the link to redirect to
	$link = $review->link;
	$this->Review_model->addClick($review->id);
	if ($link !== '') {
	    // redirect to link
	    debug('got link... redirecting to "' . $link . '"');
	    redirect($link, 'location', '301');
	} else {
	    // if there is no link, redirect to home page of site
	    debug('no link... redirecting to home page');
	    redirect(base_url(), 'location', '301');
	}
    }

}

/* End of file recommends.php */
/* Location: ./application/controllers/recommends.php */