{{
/**
 *    This file is part of OpenReviewScript - free review software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 *    Copyright (c) 2011-2012, OpenReviewScript.org
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
 */
}}
<!-- START OF 'CONTENT' SECTION -->
<div id="content">

    <div class="review_list_text">
	<h2 class="heading">{{= $site_summary_title }}</h2>
	<p>{{= $site_summary_text }}</p>
	<p>&nbsp;</p>
    </div>

    <!-- START OF CONDITIONAL 'FEATURED' SECTION -->
    {{ if ($featured_reviews >= $featured_minimum): }}
    <div class="featured">
	<h2 class="heading">{{= lang('article_page_featured_reviews') }}</h2>
	<div id="featured">
	    <div class="featured_block">
		<p class="featured_title">{{= anchor('review/show/' . $featured[0]->seo_title, highlight_keywords(character_limiter($featured[0]->title,40),$keywords )) }}</p>
		<p class="featured_description">{{= character_limiter(strip_tags($featured[0]->description), 180) }}</p>
		{{= anchor('review/show/' . $featured[0]->seo_title,lang('featured_more'),'class="read_more"') }}
	    </div>
	    <div class="featured_block">
		<p class="featured_title">{{= anchor('review/show/' . $featured[1]->seo_title, highlight_keywords(character_limiter($featured[1]->title,40),$keywords )) }}</p>
		<p class="featured_description">{{= character_limiter(strip_tags($featured[1]->description), 180) }}</p>
		{{= anchor('review/show/' . $featured[1]->seo_title,lang('featured_more'),'class="read_more"') }}
	    </div>
	    <div class="featured_block">
		<p class="featured_title">{{= anchor('review/show/' . $featured[2]->seo_title, highlight_keywords(character_limiter($featured[2]->title,40),$keywords )) }}</p>
		<p class="featured_description">{{= character_limiter(strip_tags($featured[2]->description), 180) }}</p>
		{{= anchor('review/show/' . $featured[2]->seo_title,lang('featured_more'),'class="read_more"') }}
	    </div>
	</div>
    </div>
    {{ endif }}
    <!-- END OF 'FEATURED' SECTION -->

    <!-- START OF CONDITIONAL 'LATEST' SECTION -->
    {{ if ($latest): }}
    <div class="review_list_text">
	<h2 class="heading">{{= lang('home_latest_reviews') }}</h2>
    </div>
    <div class="pagenav">{{= $pagination }}</div>
    {{ foreach ($latest as $index => $latest_result): }}

    <!-- START OF CONDITIONAL 'ADS' SECTION -->
    {{ if ($list_ads): }}
    <!-- CHANGE THE NUMBERS IN THE NEXT LINE TO CHANGE THE POSITIONS IN THE LIST WHERE ADS APPEAR -->
    {{ if (in_array($index, array(2, 6))) : }}
    <div class="block">
	{{ foreach ($list_ads as $ad) : }}
	{{ if ($ad->visible_in_lists > 0): }}
	<div class="lists_ad_block">
	    {{ if ($ad->image != ''): }}
	    <div class="ad_image">
		{{= anchor($ad->link, $ad->image) }}
	    </div>
	    {{ endif }}
	    {{ if ($ad->text != ''): }}
	    <div class="ad_text">
		{{= character_limiter($ad->text) }}
	    </div>
	    {{ endif }}
	</div>
	{{ endif }}
	{{ break }}
	{{ endforeach }}
    </div>
    {{ endif }}
    {{ endif }}
    <!-- END OF 'ADS' SECTION -->

    <!-- START OF 'REVIEW ITEM' SECTION -->
    <div class="review_item">
	<div class="title">{{= anchor('review/show/' . $latest_result->seo_title, highlight_keywords($latest_result->title, $keywords)) }}</div>
	<div class="description">
	    <div class="thumb">
		{{= anchor('review/show/' . $latest_result->seo_title, ' ','class="image" style="background: url('.$latest_result->list_thumb_url.') no-repeat center center"') }}
	    </div>
	    {{= character_limiter($latest_result->description, 300) }}
	    <div class="more_button_link">
		{{= anchor('review/show/' . $latest_result->seo_title, lang('lists_read_more'),'class="more_button"') }}
	    </div>
	    	<img src="{{= template_path() . 'design/images/' . $latest_result->rating_image }}" alt=""/>
	</div>
    </div>
    <!-- END OF 'REVIEW ITEM' SECTION -->

    {{ endforeach }}
    <div class="pagenav">{{= $pagination }}</div>
    {{ else: }}
    <!-- IF THERE ARE NO REVIEWS DISPLAY A MESSAGE -->
    <div class="message"><p>{{= lang('home_no_reviews') }}</p></div>
    {{ endif }}
    <!-- END OF 'LATEST' SECTION -->

</div>
<!-- END OF 'CONTENT' SECTION -->