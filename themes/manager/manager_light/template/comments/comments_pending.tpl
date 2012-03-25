{{
/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          manager
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

 }}
<div id="content">
      <div class="header_row">{{= lang('manager_comments_pending_title') }}</div  >
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
      <div class="break"></div>
      {{ foreach ($pendingcomments as $result): }}
            <div class="manager_row_2">
            <p class="manager_left">&#8220;{{= character_limiter($result->quotation, 512) }}&#8221;<br><span class="manager_small_text">{{= lang('manager_comments_list_review') }}{{= anchor('review/show/'.$result->seo_title, '&#8220;'.$result->title.'&#8221;)',' id="darkblue" target="_blank"') }}</span></p>
            <p class="manager_narrow">{{= anchor('manager/comment/delete_pending/'.$result->id, lang('manager_comments_list_delete'),' id="darkblue"') }}</p>
            <p class="manager_narrow">{{= anchor('manager/comment/approve_pending/'.$result->id, lang('manager_comments_approve'),' id="darkblue"') }}</p>
      </div>
      {{ endforeach }}
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
</div>