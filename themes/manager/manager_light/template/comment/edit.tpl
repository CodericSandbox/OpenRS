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
      <div class="myform">
            <div class="header_row">{{= lang('manager_comment_edit_title') }}</div  >
            <p>&nbsp;</p>
                        <p class="manager_right_link">{{= lang('manager_comments_go_back') }}<strong>"{{= anchor('manager/comments/show/' . $review->id, $review->title) }}"</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <form id="form" class="myform" name="form" method="post" action="{{= base_url() . 'manager/comment/edit/' . $comment->id }}">

                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_comment_form_quotation') }}
                                    <span class="small">{{= lang('manager_comment_form_quotation_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="quotation" id="quotation" value="{{= set_value('quotation', $comment->quotation) }}"/>
                              {{= form_error('quotation') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_comment_form_source') }}
                                    <span class="small">{{= lang('manager_comment_form_source_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="source" id="source" value="{{= set_value('source', $comment->source) }}"/>
                              {{= form_error('source') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_comment_form_approved') }}
                                    <span class="small">{{= lang('manager_comment_form_approved_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input name="approved" id="approved" type="checkbox" {{= $checked }}>
                        </div>
                  </div>
                  <input type="submit" name="comment_submit" id="button" value="{{= lang('manager_comment_form_submit_button') }}" />
            </form>
      </div>
</div>