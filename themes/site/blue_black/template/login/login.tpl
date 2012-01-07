{{
/**
* OpenReviewScript
*
* An Open Source Review Site Script
*
* @package		OpenReviewScript
* @subpackage           site
* @author		OpenReviewScript.org
* @copyright            Copyright (c) 2011, OpenReviewScript.org
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
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	{{ if($message!=''): }}
	<p>&nbsp;</p>
	<h3 class="login_error">{{= $message }}</h3>
	<p>&nbsp;</p>
	{{ endif }}
	<form class="loginform" action="{{= site_url('/login/') }}" method="post">
            <div class="formblock">
		<div class="loginleft">
		    <label>{{= lang('site_login_username') }}</label>
		</div>
		<div class="loginright">
		    <input class="userpass" type="text" name="login_username" id="login_username" value="{{= set_value('login_username') }}">
		    {{= form_error('login_username') }}
		</div>
		<div class="loginleft">
		    <label>{{= lang('site_login_password') }}</label>
		</div>
		<div class="loginright">
		    <input class="userpass" type="password" name="login_password" id="login_password" value="">
		    {{= form_error('login_password') }}
		</div>
		<div class="loginright">
		    <div class="loginforgot">
		        <label>{{= anchor('/forgot_login',lang('site_login_forgot')) }}</label>
		    </div>
		</div>
		<p>&nbsp;</p>
		<div class="loginright">
	            <input type="submit" name="login_submit" id="login_button" value="{{= lang('site_login_submit') }}" >
		</div>
            </div>
	</form>
    </div>