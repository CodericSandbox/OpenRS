{{
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

 }}
<div id="sidebar">
      <ul>
            <li>{{= anchor('manager/home', lang('manager_menu_home')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/reviews', lang('manager_menu_reviews')) }}</li>
            {{ if (pending_reviews_count()>0): }}
            <li>{{= anchor('manager/reviews/pending', lang('manager_menu_reviews_pending')) }}({{= pending_reviews_count() }})</li>
            {{ endif }}
            {{ if (pending_comments_count()>0): }}
            <li>{{= anchor('manager/comments/pending', lang('manager_menu_comments_pending')) }}({{= pending_comments_count() }})</li>
            {{ endif }}
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/categories', lang('manager_menu_categories')) }}</li>
            <li>{{= anchor('manager/features', lang('manager_menu_features')) }}</li>
            <li>{{= anchor('manager/ratings', lang('manager_menu_ratings')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/articles', lang('manager_menu_articles')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/pages', lang('manager_menu_custom_pages')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/ads', lang('manager_menu_ads')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/users', lang('manager_menu_users')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/site_settings/edit', lang('manager_menu_site_settings')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/theme_settings/edit', lang('manager_menu_theme_settings')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('manager/maintenance', lang('manager_menu_maintenance')) }}</li>
            <div class="line_break">&nbsp;</div>
            <li>{{= anchor('http://openreviewscript.org/support', lang('manager_menu_support')) }}</li>
      </ul>
</div>