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
 }}
<div id="content">
      <div class="header_row">{{= lang('manager_comments_title').'"'.$review->title.'"' }}</div  >
      <p class="nav_links"><b>{{= anchor('manager/comment/add/'.$review->id,lang('manager_comments_add_comment')) }}</b></p>
      <p class="nav_links"><b>{{= anchor('manager/review/edit/'.$review->id,lang('manager_comments_back_to_review')) }}</b></p>
      <p class="break">&nbsp;</p>
      <p class="break">&nbsp;</p>
      <p>{{= lang('manager_comments_no_comments') }}</p>
      <div class="break"><p>&nbsp;</p></div>
      <div class="break"><p>&nbsp;</p></div>
</div>