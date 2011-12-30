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
<div id="content">
      <div class="myform">
            <div class="header_row">{{= lang('manager_rating_edit_title') }}</div  >
            <p>&nbsp;</p>
            <form id="form" class="myform" name="form" method="post" action="{{= base_url() . 'manager/rating/edit/' . $rating->id }}">

                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_rating_form_name') }}
                                    <span class="small">{{= lang('manager_rating_form_name_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="name" id="name" value="{{= set_value('name', $rating->name) }}"/>
                              {{= form_error('name') }}
                        </div>
                  </div>
                  <input type="submit" name="rating_submit" id="button" value="{{= lang('manager_rating_form_submit_button') }}" />
            </form>
      </div>
</div>