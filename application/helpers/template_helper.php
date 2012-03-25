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
//
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
function template_path() {
    // return site template folder path
    $CI = & get_instance();
    $CI->load->model('Setting_model');
    return base_url() . 'themes/site/' . $CI->Setting_model->getSettingByName('current_theme') . '/';
}

function manager_template_path() {
    // return manager template folder path
    $CI = & get_instance();
    $CI->load->model('Setting_model');
    return base_url() . 'themes/manager/' . $CI->Setting_model->getSettingByName('current_manager_theme') . '/';
}

function site_logo() {
    // return the site logo image path
    $CI = & get_instance();
    $CI->load->model('Setting_model');
    return base_url() . 'uploads/site_logo/' . $CI->Setting_model->getSettingByName('site_logo_name') . '.' . $CI->Setting_model->getSettingByName('site_logo_extension');
}

/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */