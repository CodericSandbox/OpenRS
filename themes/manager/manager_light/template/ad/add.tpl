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
            <div class="header_row">{{= lang('manager_ad_add_title') }}</div  >
            <p>&nbsp;</p>
            {{ if(isset($message)): }}
                  <p>&nbsp;</p>
                  <h3>{{= $message }}</h3>
                  <p>&nbsp;</p>
            {{ endif }}
            <p>&nbsp;</p>
            <form id="form" class="myform" name="form" method="post" enctype="multipart/form-data"  enctype="multipart/form-data" action="{{= base_url() . 'manager/ad/add' }}">

                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_name') }}
                                    <span class="small">{{= lang('manager_ad_form_name_info') }}</span>

                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="name" id="name" value="{{= set_value('name', $ad->name) }}"/>
                              {{= form_error('name') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_text') }}
                                    <span class="small">{{= lang('manager_ad_form_text_info') }}</span>

                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="text" id="text" value="{{= set_value('text', $ad->text) }}"/>
                              {{= form_error('text') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_link') }}
                                    <span class="small">{{= lang('manager_ad_form_link_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input class="strong" type="text" name="link" id="link" value="{{= set_value('link', $ad->link) }}"/>
                              {{= form_error('link') }}
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_image_upload') }}
                                    <span class="small">{{= lang('manager_ad_form_image_upload_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input type="file" name="userfile" size="20" />
                              <span class="error">{{= $upload_error }}</span>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_image_url') }}
                                    <span class="small">{{= lang('manager_ad_form_image_url_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input type="text" name="remote_image_url" id="remote_image_url" value="{{= set_value('remote_image_url',$ad->image_url) }}" />
                              <span class="error">{{= $url_error }}</span>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_image_width') }}
                                    <span class="small">{{= lang('manager_ad_form_image_width_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input type="text" name="image_width" id="image_width" value="{{= set_value('image_width',$ad->image_width) }}" />
                              <span class="error">{{= $image_width_error }}</span>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_image_height') }}
                                    <span class="small">{{= lang('manager_ad_form_image_height_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input type="text" name="image_height" id="image_height" value="{{= set_value('image_height',$ad->image_height) }}" />
                              <span class="error">{{= $image_height_error }}</span>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_visible_in_sidebar') }}
                                    <span class="small">{{= lang('manager_ad_form_visible_in_sidebar_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input name="visible_in_sidebar" id="approved" type="checkbox" CHECKED>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_visible_in_lists') }}
                                    <span class="small">{{= lang('manager_ad_form_visible_in_lists_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input name="visible_in_lists" id="approved" type="checkbox" CHECKED>
                        </div>
                  </div>
                  <div class="formblock">
                        <div class="formleft">
                              <label>{{= lang('manager_ad_form_visible_on_review_page') }}
                                    <span class="small">{{= lang('manager_ad_form_visible_on_review_page_info') }}</span>
                              </label>
                        </div>
                        <div class="formright">
                              <input name="visible_on_review_page" id="approved" type="checkbox" CHECKED>
                        </div>
                  </div>
                  <input type="submit" name="ad_submit" id="button" value="{{= lang('manager_ad_form_submit_button') }}" />
            </form>
      </div>
</div>