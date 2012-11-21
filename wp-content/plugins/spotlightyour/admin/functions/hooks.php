<?php
///=============HEADER SETTINGS========================================/////

/************************************
//FUNCTION NAME : DDBWP_footer_settings
//ARGUMENTS : None
//RETURNS : Footer scripts desing option content
***************************************/
add_action('wp_footer','DDBWP_footer_settings');
function DDBWP_footer_settings()
{
	echo stripslashes(get_option('ddbwpthemes_scripts_footer'));
}

/************************************
//FUNCTION NAME : DDBWP_header_settings
//ARGUMENTS : None
//RETURNS : Site Header inside <head>...</head> settings
***************************************/

function DDBWP_head_css_settings()
{ 
	$stylesheet = get_option('ddbwpthemes_alt_stylesheet');
	
	if($stylesheet != '')
	{
	?>
	<link href="<?php echo DDB_PUGIN_URL;?>/skins/<?php echo $stylesheet; ?>.css" rel="stylesheet" type="text/css" />
	<?php }
	
	if(apply_filters('DDBWP_additional_css_settings', true))
	{
		@include_once(DDB_ADMIN_FOLDER_PATH.'add_style.php');
	}
	if(strtolower(get_option('ddbwpthemes_customcss'))=='activate')
	{
	?>
		<link href="<?php echo DDB_PUGIN_URL;?>/custom.css" rel="stylesheet" type="text/css" />
	<?php
	}
}
add_action('DDBWP_head_js','DDBWP_head_js_settings');

add_action('DDBWP_head_css','DDBWP_head_css_settings');
function DDBWP_head_js_settings()
{
	echo stripslashes(get_option('ddbwpthemes_scripts_header'));
}


add_action('DDBWP_head_meta','DDBWP_header_settings');
function DDBWP_header_settings()
{
	if(get_option('ddbwpthemes_favicon'))
	{
	?>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_option('ddbwpthemes_favicon'); ?>" />
    <?php	
	}
	if(get_option('ddbwpthemes_feedburner_url'))
	{
		if (apply_filters('DDBWP_facebook_button_script', true))
		{
	?>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo get_option('ddbwpthemes_feedburner_url'); ?>" />
    <?php
		}
	}
	DDBWP_seo_meta();
}

///=============Page Title Above ========================================/////
function DDBWP_page_title_above()
{
	do_action('DDBWP_page_title_above');	
}

///=============Page Title Below ========================================/////
function DDBWP_page_title_below()
{
	do_action('DDBWP_page_title_below');	
}

///=============SITE LOGO SETTINGS========================================/////
function DDBWP_site_logo()
{
	do_action('DDBWP_site_logo');
}

///=============TWITTER BUTTON========================================/////
function DDBWP_show_twitter_button()
{
	do_action('DDBWP_show_twitter_button');	
}

///=============FACEBOOK BUTTON========================================/////
function DDBWP_show_facebook_button()
{
	do_action('DDBWP_show_facebook_button');	
}


///=============TOP HEADER NAVIGATION========================================/////
function DDBWP_get_top_header_navigation()
{
	do_action('DDBWP_get_top_header_navigation');	
}


///=============MAIN HEADER NAVIGATION========================================/////
function DDBWP_get_main_header_navigation()
{
	do_action('DDBWP_get_main_header_navigation');	
}

///=============EXCERPT LENGTH SETTING FILTER========================================/////
function DDBWP_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'DDBWP_excerpt_length');

///=============SEO META TAGS========================================/////
function DDBWP_seo_meta()
{
	do_action('DDBWP_seo_meta');	
}



/************************************
Layout Hooks 
***************************************/
///=============HEADER HOOK========================================/////
function DDBWP_wp_head()
{
	do_action('DDBWP_wp_head');	
}

///=============BODY START HOOK========================================/////
function DDBWP_body_start()
{
	do_action('DDBWP_body_start');	
}

///=============BODY END HOOK========================================/////
function DDBWP_body_end()
{
	do_action('DDBWP_body_end');	
}
///=============HEADER START HOOK========================================/////
function DDBWP_header_start()
{
	do_action('DDBWP_header_start');	
}

///=============HEADER END HOOK========================================/////
function DDBWP_header_end()
{
	do_action('DDBWP_header_end');	
}
///=============CONTENT START HOOK========================================/////
function DDBWP_content_start()
{
	do_action('DDBWP_content_start');	
}

///=============CONTENT END HOOK========================================/////
function DDBWP_content_end()
{
	do_action('DDBWP_content_end');	
}
///=============BEFORE SINGLE ENTRY HOOK========================================/////
function DDBWP_before_single_entry()
{
	do_action('DDBWP_before_single_entry');	
}

///=============AFTER SINGLE ENTRY HOOK========================================/////
function DDBWP_after_single_entry()
{
	do_action('DDBWP_after_single_entry');	
}
///=============BEFORE SINGLE POST CONTENT HOOK========================================/////
function DDBWP_before_single_post_content()
{
	do_action('DDBWP_before_single_post_content');	
}

///=============AFTER SINGLE POST CONTENT HOOK========================================/////
function DDBWP_after_single_post_content()
{
	do_action('DDBWP_after_single_post_content');	
}
///=============BEFORE LOOP HOOK========================================/////
function DDBWP_before_loop()
{
	do_action('DDBWP_before_loop');	
}

///=============AFTER LOOP HOOK========================================/////
function DDBWP_after_loop()
{
	do_action('DDBWP_after_loop');	
}
///=============BEFORE LOOP POST CONTENT HOOK========================================/////
function DDBWP_before_loop_post_content()
{
	do_action('DDBWP_before_loop_post_content');	
}

///=============AFTER LOOP POST CONTENT HOOK========================================/////
function DDBWP_after_loop_post_content()
{
	do_action('DDBWP_after_loop_post_content');	
}
///=============BEFORE SIDEBAR HOOK========================================/////
function DDBWP_before_sidebar()
{
	do_action('DDBWP_before_sidebar');	
}

///=============AFTER SIDEBAR HOOK========================================/////
function DDBWP_after_sidebar()
{
	do_action('DDBWP_after_sidebar');	
}
///=============BEFORE FOOTER HOOK========================================/////
function DDBWP_before_footer()
{
	do_action('DDBWP_before_footer');	
}

///=============AFTER FOOTER HOOK========================================/////
function DDBWP_after_footer()
{
	do_action('DDBWP_after_footer');	
}



/************************************
//FUNCTION NAME : DDBWP_get_listing_content
//ARGUMENTS :NONE
//RETURNS : display content or excerpt or sub part of it.
***************************************/
function DDBWP_get_listing_content()
{
	do_action('DDBWP_get_listing_content');	
}

/************************************
//FUNCTION NAME : DDBWP_comments_link_attributes
//ARGUMENTS : NONE
//RETURNS : Comment link class added via filter
***************************************/
function DDBWP_comments_link_attributes(){
    return ' class="comments_popup_link" ';
}
add_filter('comments_popup_link_attributes', 'DDBWP_comments_link_attributes');

/************************************
//FUNCTION NAME : DDBWP_next_posts_attributes
//ARGUMENTS : NONE
//RETURNS : Post link class added via filter
***************************************/
function DDBWP_next_posts_attributes(){
    return ' class="nextpostslink" ';
}
add_filter('next_posts_link_attributes', 'DDBWP_next_posts_attributes');


function DDBWP_previous_posts_attributes(){
    return ' class="previouspostslink" ';
}
add_filter('previous_posts_link_attributes', 'DDBWP_previous_posts_attributes');



/************************************
//FUNCTION NAME : DDBWP_get_top_header_navigation_above
//ARGUMENTS : NONE
//RETURNS : Top header navigation above content hook
***************************************/
function DDBWP_get_top_header_navigation_above()
{
	do_action('DDBWP_get_top_header_navigation_above');	
}

/************************************
//FUNCTION NAME : DDBWP_add_template_page_hook
//ARGUMENTS : NONE
//RETURNS : add New pages via this action hook
***************************************/
function DDBWP_add_template_page_hook()
{
	do_action('DDBWP_add_template_page_hook');
}
/************************************
//FUNCTION NAME : DDBWP_set_listing_post_per_page
//ARGUMENTS : None
//RETURNS : Set the filete for the post per page for listing page
***************************************/
function DDBWP_post_limits_listing_page() {
	global $posts_per_page;
	if ( is_home() || is_search()  || is_archive())
	{
		if(is_home())
		{
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ddbwpthemes_home_page')>0)
			{
				$rtr = get_option('ddbwpthemes_home_page');
			}else
			{
				$rtr =  10;	
			}
				
		}
		if ( is_archive())
		{
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ddbwpthemes_cat_page')>0)
			{
				$rtr = get_option('ddbwpthemes_cat_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		if ( is_search())
		{
			
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ddbwpthemes_search_page')>0)
			{
				$rtr = get_option('ddbwpthemes_search_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		return $rtr;
	}
	if ( is_category() || is_month() || is_year() || is_tag() || is_date())
	{
		if($_REQUEST['per_pg'])
		{
			$rtr = $_REQUEST['per_pg'];
		}elseif($posts_per_page)
		{
			$rtr =  $posts_per_page;
		}else
		{
			$rtr =  10;	
		}
		return $rtr;
	}
}
add_filter('pre_option_posts_per_page', 'DDBWP_post_limits_listing_page');

/************************************
//FUNCTION NAME : DDBWP_page_title_filter
//ARGUMENTS : title,starting tag,ending tag
//RETURNS : filtered contnet
***************************************/
function DDBWP_page_title_filter($title,$st='',$end='')
{
	return apply_filters('DDBWP_page_title_filter',$st.$title.$end);
}

/************************************
//FUNCTION NAME : DDBWP_thumbimage_filter
//ARGUMENTS : image src,height-width argument
//RETURNS : thumb image url 
***************************************/
function DDBWP_thumbimage_filter($src,$att='&amp;w=100&amp;h=100&amp;zc=1&amp;q=80',$isresize=0)
{
	global $thumb_url;
	if(strtolower(get_option('ddbwpthemes_timthumb'))=='yes' || get_option('ddbwpthemes_timthumb')=='' || $isresize)
	$imgurl = DDB_PUGIN_URL.'/thumb.php?src='.$src.$att.$thumb_url;
	else
	$imgurl = $src;
	
	return apply_filters('DDBWP_thumbimage_filter',$imgurl);
}
?>
