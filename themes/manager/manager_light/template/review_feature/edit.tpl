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
            <div class="header_row">{{= lang('manager_review_feature_edit_title') }}</div  >
            <p>&nbsp;</p>
            <p class="manager_right_link">{{= lang('manager_review_features_go_back') }}<strong>"{{= anchor('manager/review_features/show/' . $review->id, $review->title) }}"</strong></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <form id="form" class="myform" name="form" method="post" action="{{= base_url() . 'manager/review_feature/edit/' . $review_feature->id }}">
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_review_features_form_feature') }}
                                    <span class="small">{{= lang('manager_review_features_form_feature_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              {{= form_dropdown('feature_id', $features, $selected_feature) }}
                              {{= form_error('feature_id') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_review_features_form_value') }}
                                    <span class="small">{{= lang('manager_review_features_form_value_info') }}</span>

                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="value" id="value" value="{{= set_value('value', $review_feature->value) }}"/>
                              {{= form_error('value') }}
                        </div>
                  </div>
                  <p>&nbsp;</p>it_button') }}" />
            </form>
      </div>
</div>