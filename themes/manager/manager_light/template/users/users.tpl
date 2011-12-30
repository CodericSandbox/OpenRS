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
      <div class="header_row">{{= lang('manager_users_title') }}</div  >
      <p class="nav_links"><b>{{= anchor('manager/user/add',lang('manager_users_add_user')) }}</b></p>
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
      <div class="break"></div>
      {{ foreach ($allusers as $result): }}
            <div class="manager_row">
            <p class="manager_left">{{= $result->name }}</p>
            <p class="manager_narrow">{{= $result->level }}</p>
            <p class="manager_narrow">{{= anchor('manager/user/edit/'.$result->id, lang('manager_user_list_edit')) }}</p>
            {{ if(($enough_managers_to_delete) OR ($result->level<10)): }}
                  <p class="manager_narrow">{{= anchor('manager/user/delete/'.$result->id, lang('manager_user_list_delete'),'id="darkblue"') }}</p>
            {{ else: }}
                  <p class="manager_narrow" style="width:150px;">{{= lang('manager_user_list_cant_delete') }}</p>
            {{ endif }}
      </div>
      {{ endforeach }}
      <div class="pagenav">{{= lang('manager_page') }}{{= $pagination }}</div>
</div>