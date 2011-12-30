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
            <div class="header_row">{{= lang('manager_ad_delete_title').'&#8220;'.$ad->name.'&#8221;' }}</div  >
            <p>&nbsp;</p>
            <h3>{{= lang('manager_ad_delete_warning') }}</h3>
            <p>&nbsp;</p>
            <h3>{{= anchor('manager/ad/deleted/'.$ad->id,lang('manager_ad_delete_confirm')) }}&nbsp;|&nbsp;{{= anchor('manager/ads',lang('manager_ad_delete_cancel')) }}</h3>
      </div>
</div>