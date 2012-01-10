<!--
 *    This file is part of OpenReviewScript - free review software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 *    Copyright (c) 2011, OpenReviewScript.org
 *    http://OpenReviewScript.org
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
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en"/>
	<meta name="keywords" content="{{=  $meta_keywords }}" />
	<meta name="description" content="{{=  $meta_description }}" />
	<title>{{=  $page_title }}</title>
	<link href="{{=  template_path() }}design/style.css" rel="stylesheet" type="text/css"/>
	<link rel="alternate" type="application/rss+xml" title="Latest Reviews (RSS2.0)" href="{{=  base_url() . 'rss' }}" />
	<script language="JavaScript" type="text/javascript">
	    <!--
	    function dosearch (formname)
	    {
		theform = document.forms[formname];
		theform.submit();
		return false;
	    }
	    -->
	</script>
	<script type="text/javascript" src="{{=  base_url() }}libs/lightbox2.04/js/prototype.js"></script>
	<script type="text/javascript" src="{{=  base_url() }}libs/lightbox2.04/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="{{=  base_url() }}libs/lightbox2.04/js/lightbox.js"></script>
	<link rel="stylesheet" href="{{=  base_url() }}libs/lightbox2.04/css/lightbox.css" type="text/css" media="screen" />
	<script src="{{=  base_url() }}libs/jquery/jquery-1.6.4.min.js" type="text/javascript"></script>
	<script src="{{=  base_url() }}libs/jquery/jquery.form.js" type="text/javascript"></script>
	<script src='{{=  base_url() }}libs/star-rating/jquery.rating.js' type="text/javascript" language="javascript"></script>
	<link href='{{=  base_url() }}libs/star-rating/jquery.rating.css' type="text/css" rel="stylesheet"/>
    </head>

    <body>
	
	<!-- START OF 'MAIN' SECTION -->
	<div id="main">
	    
	    <!-- START OF 'CONTAINER' SECTION -->
	    <div id="container">

		<!-- START OF 'NAVBAR' SECTION -->
		<div id="navbar">
		    <ul>
			<li>{{=  anchor('contact', lang('top_nav_contact_us')) }}</li>
			<li><p></p></li>
			<li>{{=  anchor('page/show/about_us', lang('top_nav_about_us')) }}</li>
			<li><p></p></li>
			<li>{{=  anchor('page/show/privacy_policy_terms_and_conditions', lang('top_nav_privacy')) }}</li>
			<li><p></p></li>
			<li>{{=  anchor('articles', lang('top_nav_articles')) }}</li>
			<li><p></p></li>
			<li>{{=  anchor('/', lang('top_nav_home')) }}</li>
			<li><p></p></li>
		    </ul>
		</div>
		<!-- END OF 'NAVBAR' SECTION -->
		    {{ if ($this->secure->isLoggedIn($this->session)): }}
		    <div class="login">{{= lang('site_logged_in_as').' ('.$this->session->userdata('name').') | '.anchor('/logout',lang('site_log_out')) }}</div>
		    {{ else: }}
<div class="login">{{= lang('site_not_logged_in') .' | '.anchor('/login',lang('site_log_in')).' | '.anchor('/register',lang('site_register')) }}</div>		    {{ endif }}

		<!-- START OF 'HEADER' SECTION -->
		<div id="header" style="background: url({{= site_logo() }}) no-repeat 30px center;">
		</div>
		<!-- END OF 'HEADER' SECTION -->

		{{=  $sidebar }}
		{{=  $content }}
	    </div>
	    <!-- END OF 'CONTAINER' SECTION -->
	    
	    <!-- START OF 'FOOTER' SECTION -->
	    <div id="footer">
		<div id="footer_content">
		    <div id="footer_column">
			<h4>{{=  anchor(base_url(), 'Latest Reviews') }}</h4>
			<h4>{{=  anchor('articles', lang('top_nav_articles')) }}</h4>
		    </div>
		    <div id="footer_column">
			<h4>{{=  anchor('page/show/about_us', lang('top_nav_about_us')) }}</h4>
			<h4>{{=  anchor('contact', lang('top_nav_contact_us')) }}</h4>
		    </div>
		    <div id="footer_column">
			<h4>{{=  anchor('page/show/privacy_policy_terms_and_conditions', lang('top_nav_privacy')) }}</h4>
			<h4><a href="{{=  base_url() . 'rss' }}">RSS</a></h4>
		    </div>
		    <div id="footer_copyright">
		    Copyright &copy;2011 Powered by <a href="http://openreviewscript.org">OpenReviewScript</a>
		    </div>
		</div>
	    </div>
	    <!-- END OF 'FOOTER' SECTION -->

	</div>
	<!-- END OF 'MAIN' SECTION -->
    </body>
</html>
