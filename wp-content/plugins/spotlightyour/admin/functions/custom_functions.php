<?php
/////////PRODUCT DETAIL PAGE FUNCTIONS START///////////////
function DDBWP_is_show_listing_author()
{	
	if(strtolower(get_option('ddbwpthemes_listing_author'))=='yes' || get_option('ddbwpthemes_listing_author')=='')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_listing_date()
{
	if(strtolower(get_option('ddbwpthemes_listing_date'))=='yes' || get_option('ddbwpthemes_listing_date')=='')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_listing_comment()
{
	if(strtolower(get_option('ddbwpthemes_listing_comment'))=='yes' || get_option('ddbwpthemes_listing_comment')=='')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_listing_category()
{
	if(strtolower(get_option('ddbwpthemes_listing_category'))=='yes' || get_option('ddbwpthemes_listing_category')=='')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_listing_tags()
{
	if(strtolower(get_option('ddbwpthemes_listing_tags'))=='yes' || get_option('ddbwpthemes_listing_tags')=='')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_capcha()
{
	if(strtolower(get_option('ddbwpthemes_capcha'))=='yes' || get_option('ddbwpthemes_capcha')=='')
	{
		return true;	
	}
	return false;
}

/////////PRODUCT DETAIL PAGE FUNCTIONS END///////////////

/////////PRODUCT DETAIL PAGE FUNCTIONS START///////////////
function DDBWP_is_show_post_author()
{
	if(strtolower(get_option('ddbwpthemes_details_author'))=='yes' || get_option('ddbwpthemes_details_author')=='')
	{
		return true;	
	}
	return false;
}

function DDBWP_is_show_post_date()
{
	if(strtolower(get_option('ddbwpthemes_details_date'))=='yes' || get_option('ddbwpthemes_details_date')=='')
	{
		return true;	
	}
	return false;
}

function DDBWP_is_show_post_comment()
{
	if(strtolower(get_option('ddbwpthemes_details_comment'))=='yes' || get_option('ddbwpthemes_details_comment')=='')
	{
		return true;	
	}
	return false;
}

function DDBWP_is_show_post_category()
{
	if(strtolower(get_option('ddbwpthemes_details_category'))=='yes' || get_option('ddbwpthemes_details_category')=='')
	{
		return true;	
	}
	return false;
}

function DDBWP_is_show_post_tags()
{
	if(strtolower(get_option('ddbwpthemes_details_tags'))=='yes' || get_option('ddbwpthemes_details_tags')=='')
	{
		return true;	
	}
	return false;
}
/////////PRODUCT DETAIL PAGE FUNCTIONS END///////////////

/////////FOOTER FUNCTIONS START///////////////
function DDBWP_is_footer_widgets_2colright()
{
	if(get_option('ddbwpthemes_bottom_options')=='Two Column - Right(one third)')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_footer_widgets_2colleft()
{
	if(get_option('ddbwpthemes_bottom_options')=='Two Column - Left(one third)')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_footer_widgets_eqlcol()
{
	if(get_option('ddbwpthemes_bottom_options')=='Equal Column')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_footer_widgets_3col()
{
	if(get_option('ddbwpthemes_bottom_options')=='Three Column')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_footer_widgets_4col()
{
	if(get_option('ddbwpthemes_bottom_options')=='Four Column')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_footer_widgets_fullwidth()
{
	if(get_option('ddbwpthemes_bottom_options')=='Full Width')
	{
		return true;	
	}
	return false;
}

///////////////OTHER FLAG SETTINGS START////////////////////
function DDBWP_is_ajax_pagination()
{
	if (get_option('ddbwpthemes_pagination') == 'AJAX-fetching posts')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_third_party_seo()
{
	if(strtolower(get_option('ddbwpthemes_use_third_party_data'))=='yes')
	{
		return true;	
	}
	return false;		
}
function DDBWP_is_top_home_link()
{
	if(strtolower(get_option('ddbwpthemes_top_home_links'))=='yes' || get_option('ddbwpthemes_top_home_links')=='' )
	{
		return true;
	}
	return false;
}
function DDBWP_is_top_pages_nav()
{
	if(get_option('ddbwpthemes_top_pages_nav')!="" && !strstr(get_option('ddbwpthemes_top_pages_nav'),'none'))
	{
		return true;
	}
	return false;
}
function DDBWP_is_top_category_nav()
{
	if(get_option('ddbwpthemes_category_top_nav')!="" && !strstr(get_option('ddbwpthemes_category_top_nav'),'none'))
	{
		return true;
	}
	return false;
}
function DDBWP_is_facebook_button()
{
	if(strtolower(get_option('ddbwpthemes_facebook_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_tweet_button()
{
	if(strtolower(get_option('ddbwpthemes_tweet_button'))=='yes')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_show_blog_title()
{
	if(strtolower(get_option('ddbwpthemes_show_blog_title'))=='yes')
	{
		return true;	
	}
	return false;
}
function DDBWP_is_php_mail()
{
	//if(get_option('ddbwpthemes_notification_type')=='PHP Mail')
	//{
		//return true;	
	//
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
	return false;
}
function DDBWP_is_auto_install()
{
	if(strtolower(get_option('ddbwpthemes_auto_install'))=='yes')
	{
		return true;	
	}
	return false;
}
///////////////OTHER FLAG SETTINGS END////////////////////


/************************************
//FUNCTION NAME : DDBWP_sendEmail
//ARGUMENTS : from email ID,From email Name, To email ID, To email name, Mail Subject, Mail Content, Mail Header.
//RETURNS : Send Mail to the email address.
***************************************/
function DDBWP_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$fromEmail = apply_filters('DDBWP_send_from_emailid', $fromEmail);
	$fromEmailName = apply_filters('DDBWP_send_from_emailname', $fromEmailName);
	$toEmail = apply_filters('DDBWP_send_to_emailid', $toEmail);
	$toEmailName = apply_filters('DDBWP_send_to_emailname', $toEmailName);
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
	$subject = apply_filters('DDBWP_send_email_subject', $subject);
	$message = apply_filters('DDBWP_send_email_content', $message);
	$headers = apply_filters('DDBWP_send_email_headers', $headers);
	
	// Mail it
	if(DDBWP_is_php_mail() && 0)
	{
		@mail($toEmail, $subject, $message, $headers);	
	}else
	{
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		wp_mail($toEmail, $subject, $message, $headers);		
		//$headers = 'From: '.$_POST['name'].' <'.$_POST['email'].'>' . "\r\n";
		
	}	
}
/************************************
//FUNCTION NAME : DDBWP_getTinyUrl
//ARGUMENTS :source url
//RETURNS : Tiny URL created
***************************************/
function DDBWP_getTinyUrl($url) {
    //$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
	$tinyurl = $url;
    return $tinyurl;
}


/************************************
//FUNCTION NAME : DDBWP_get_date_format
//ARGUMENTS :None
//RETURNS : date format as per set from design settings
***************************************/
function DDBWP_get_date_format()
{
	return DDBWP_date_format();
}

function DDBWP_date_format()
{
	$date_format = get_option('ddbwpthemes_date_format');
	if(!$date_format){$date_format = get_option('date_format');}
	if(!$date_format){$date_format = 'yyyy-mm-dd';}
	return apply_filters('DDBWP_date_formate_filter',$date_format);
}
/************************************
//FUNCTION NAME : DDBWP_get_time_format
//ARGUMENTS :None
//RETURNS : time format as per set from design settings
***************************************/
function DDBWP_get_time_format()
{
	return DDBWP_time_format();
}

function DDBWP_time_format()
{
	$time_format = get_option('ddbwpthemes_time_format');
	if(!$time_format){ $time_format = get_option('time_format');}
	if($time_format==''){$time_format = 'g:s a';}
	return apply_filters('DDBWP_time_formate_filter',$time_format);
}

/************************************
//FUNCTION NAME : DDBWP_get_formated_date
//ARGUMENTS :Input date in 'Y-m-d' format (eg:- 2011-01-31)
//RETURNS : formated date as per set from design settings
***************************************/
function DDBWP_get_formated_date($date)
{
	return DDBWP_date_formated($date);	
}

function DDBWP_date_formated($date)
{
	$date_format = DDBWP_get_date_format();
	if($date)
	{
		return apply_filters('DDBWP_get_formated_date_filter',date($date_format,strtotime($date)));	
	}
}

/************************************
//FUNCTION NAME : DDBWP_get_site_contact_email
//ARGUMENTS :NONE
//RETURNS : site email set from design settings or admin email
***************************************/
function DDBWP_get_site_contact_email()
{
	return DDBWP_site_contact_email();
}

function DDBWP_site_contact_email()
{
	$site_email = get_option('pttheme_contact_email');
	if($site_email=='')
	{
		$site_email = get_option('admin_email');	
	}
	return apply_filters('DDBWP_get_site_contact_email_filter',$site_email);
}

/************************************
//FUNCTION NAME : DDBWP_set_breadcrumbs_navigation
//ARGUMENTS :arg1=custom seperator, arg2=cutom breadcrumbs content
//RETURNS : breadcrums for each pages
***************************************/
function DDBWP_set_breadcrumbs_navigation($arg1='',$arg2='')
{
	do_action('DDBWP_set_breadcrumbs_navigation');
	if (strtolower(get_option( 'ddbwpthemes_breadcrumbs'))=='yes') {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in">
		<?php 
		ob_start();
		yoast_breadcrumb(''.$arg1,''.$arg2);
		$breadcrumb = ob_get_contents();
		ob_end_clean();
		echo apply_filters('DDBWP_breadcrumbs_navigation_filter',$breadcrumb);
		?></div>
    </div>
    <?php }
}

/************************************
//FUNCTION NAME : DDBWP_get_excerpt
//ARGUMENTS :string content, number of characters limit
//RETURNS : string with limit of number of characters
***************************************/
function DDBWP_get_excerpt($string, $limit='',$post_id='') {
	global $post;
	if(!$post_id)
	{
		$post_id=$post->ID;
	}
	$read_more = stripslashes(get_option('ddbwpthemes_content_excerpt_readmore'));
	if($read_more)
	{
		$read_more = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.$read_more.'</a>';
	}else
	{
		$read_more = ' <a href="'.get_permalink($post_id).'" title="" class="read_more">'.__('read more','ddb_wp').'</a>';
	}
	$read_more = apply_filters('DDBWP_get_excerpt_readmore_filter',$read_more);
	if($limit)
	{
		$words = explode(" ",$string);
		if ( count($words) >= $limit)
		return apply_filters('DDBWP_get_excerpt_filter',implode(" ",array_splice($words,0,$limit)).$read_more);
		else
		return apply_filters('DDBWP_get_excerpt_filter',$string.$read_more);
		
	}else
	{
		return apply_filters('DDBWP_get_excerpt_filter',$string.$read_more);
	}
}

/************************************
//FUNCTION NAME : DDBWP_listing_content
//ARGUMENTS :NONE
//RETURNS : display content or excerpt or sub part of it.
***************************************/
function DDBWP_listing_content()
{
	if (apply_filters('DDBWP_get_listing_content_filter', true))
	{
		if(get_option('ddbwpthemes_postcontent_full')=='Full Content')
		{
			the_content();		
		}else
		{
			$limit = get_option('ddbwpthemes_content_excerpt_count');
			echo DDBWP_get_excerpt(get_the_excerpt(), $limit);
		}
	}
}
add_action('DDBWP_get_listing_content','DDBWP_listing_content');


/************************************
//FUNCTION NAME : DDBWP_seo_meta_content
//ARGUMENTS : None
//RETURNS : Meta Content, Description and Noindex settings for SEO
***************************************/
function DDBWP_seo_meta_content()
{
	if (is_home() || is_front_page()) 
	{
		$description = stripslashes(get_option('ddbwpthemes_home_desc_seo'));
		$keywords = stripslashes(get_option('ddbwpthemes_home_keyword_seo'));
	}elseif (is_single() || is_page())
	{
		global $post;
		$description = get_post_meta($post->ID,'DDBWP_seo_page_desc',true);
		$keywords = get_post_meta($post->ID,'DDBWP_seo_page_kw',true);
	}
	
	if(is_archive() && strtolower(get_option( 'ddbwpthemes_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots" content="noindex" />';
	}elseif(is_tag() && strtolower(get_option( 'ddbwpthemes_tag_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}elseif(is_archive() && strtolower(get_option('ddbwpthemes_category_noindex'))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}
	if($description){ echo '<meta content="'.$description.'" name="description" />';}
	if($keywords){ echo '<meta content="'.$keywords.'" name="keywords" />';}
	
}
add_action('DDBWP_seo_meta','DDBWP_seo_meta_content');

/************************************
//FUNCTION NAME : DDBWP_seo_title
//ARGUMENTS : None
//RETURNS : SEO page title
***************************************/
function DDBWP_seo_title() {
	if(DDBWP_is_third_party_seo()){
	}else
	{
		global $page, $paged;
		$sep = " | "; # delimiter
		$newtitle = get_bloginfo('name'); # default title
	
		# Single & Page ##################################
		if (is_single() || is_page())
		{
			global $post;
			$newtitle = get_post_meta($post->ID,'DDBWP_seo_page_title',true);
			if($newtitle=='')
			{
				$newtitle = single_post_title("", false);
			}
		}
	
		# City ######################################
		if (is_category())
			$newtitle = single_cat_title("", false);
	
		# Tag ###########################################
		if (is_tag())
		 $newtitle = single_tag_title("", false);
	
		# Search result ################################
		if (is_search())
		 $newtitle = __("Search Result ",'ddb_wp') . $s;
	
		# Taxonomy #######################################
		if (is_tax()) {
			$curr_tax = get_taxonomy(get_query_var('taxonomy'));
			$curr_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); # current term data
			# if it's term
			if (!empty($curr_term)) {
				$newtitle = $curr_tax->label . $sep . $curr_term->name;
			} else {
				$newtitle = $curr_tax->label;
			}
		}
	
		if ( is_author() ) {
			$newtitle = __('Author Archives','ddb_wp');
		}
		# Page number
		if ($paged >= 2 || $page >= 2)
				$newtitle .= $sep . sprintf('Page %s', max($paged, $page));
	
		# Home & Front Page ########################################
		if (is_home() || is_front_page()) {
			if(get_option('ddbwpthemes_home_title_seo')){
				$newtitle = stripslashes(get_option('ddbwpthemes_home_title_seo'));
			}else
			{
				$newtitle = get_bloginfo('name') . $sep . stripslashes(get_bloginfo('description'));
			}
		} else {
			$newtitle .=  $sep . get_bloginfo('name');
		}
		$pos = strpos($_SERVER['REQUEST_URI'], "feed");
		if($pos != '' || $pos != 0)
		{
			$newtitle = '';
		}
		return $newtitle;
	}
}
add_filter('wp_title', 'DDBWP_seo_title');

/************************************
//FUNCTION NAME : DDBWP_main_header_navigation_content
//ARGUMENTS : None
//RETURNS : Get Header Main Menu Action Hook
***************************************/
function DDBWP_main_header_navigation_content()
{
	/* if(strtolower(get_option('ddbwpthemes_main_pages_nav_enable'))!='deactivate'){?>
    
    <div class="main_nav">
    	<div class="main_nav_in">
     
        <?php apply_filters('DDBWP_main_header_nav_above_filter','');?>
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Main Navigation') ){}else{  ?>
        <ul class="clearfix">
        
           <?php if(strtolower(get_option('ddbwpthemes_main_nav_home_links'))=='yes' || get_option('ddbwpthemes_main_nav_home_links')=='' ){?> <li class="<?php if ( is_home() ) { ?>current_page_item<?php } ?> home" ><a href="<?php echo get_option('home'); ?>/"><?php _e('Home');?></a></li><?php }?>
		
        
         <?php if(get_option('ddbwpthemes_include_main_nav')!="" && !strstr(get_option('ddbwpthemes_include_main_nav'),'none')){ wp_list_pages('title_li=&depth=0&include=' . get_option('ddbwpthemes_include_main_nav') .'&sort_column=menu_order'); }  ?>
         
          <?php
	 if(get_option('ddbwpthemes_category_main_nav')!="" && !strstr(get_option('ddbwpthemes_category_main_nav'),'none')){ 
		$catlist_blog =  wp_list_categories('title_li=&include=' . get_option('ddbwpthemes_category_main_nav') .'&echo=0');
    if(!strstr($catlist_blog,'No categories'))
	 {
		 echo $catlist_blog;
	 }
	 }
     ?>
         </ul>
          <?php }?>
         <?php apply_filters('DDBWP_main_header_nav_below_filter','');?>	 
         	 </div>
         </div>
    <?php }*/
	?>
    <?php if(strtolower(get_option('ddbwpthemes_main_pages_nav_enable'))!='deactivate'){?>
        <div class="main_nav">
        <div class="main_nav_in clearfix">
         <?php apply_filters('DDBWP_main_header_nav_above_filter','');?>
        <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ));?>
        <?php if (function_exists('dynamic_sidebar') ){dynamic_sidebar('Main Navigation');} ?>
        <?php apply_filters('DDBWP_main_header_nav_below_filter','');?>
        </div></div>
    <?php
	}
}
add_action('DDBWP_get_main_header_navigation','DDBWP_main_header_navigation_content');


/************************************
//FUNCTION NAME : DDBWP_top_header_navigation_content
//ARGUMENTS : None
//RETURNS : Get Header Top Menu Action Hook
***************************************/
function DDBWP_top_header_navigation_content()
{
	 /*if(strtolower(get_option('ddbwpthemes_top_pages_nav_enable'))!='deactivate'){?>
    <div class="top_navigation">
        	 <div class="top_navigation_in">
             	
        <?php apply_filters('DDBWP_top_header_nav_above_filter','');?>
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('top_navigation') ){}else{  ?>
         <ul  class="clearfix">
          <?php if(DDBWP_is_top_home_link()){?> <li class="<?php if ( is_home() ) { ?>current_page_item<?php } ?> home" ><a href="<?php echo get_option('home'); ?>/"><?php _e('Home');?></a></li><?php }?>
         
		 <?php if(DDBWP_is_top_pages_nav()){ 
		 wp_list_pages('title_li=&depth=0&include=' . get_option('ddbwpthemes_top_pages_nav') .'&sort_column=menu_order');
		 }?>
         
         <?php
	 if(DDBWP_is_top_category_nav()){
		$catlist_blog =  wp_list_categories('title_li=&include=' . get_option('ddbwpthemes_category_top_nav') .'&echo=0');
		if(!strstr($catlist_blog,'No categories'))
		 {
			 echo $catlist_blog;
		 }
	 }
     ?>
         </ul>
          <?php }?>
          <?php apply_filters('DDBWP_top_header_nav_below_filter','');?>
         	</div>
         </div>
    <?php }*/
	?>
    <?php if(strtolower(get_option('ddbwpthemes_top_pages_nav_enable'))!='deactivate'){?>
        <div class="top_navigation">
        <div class="top_navigation_in clearfix">
        <?php apply_filters('DDBWP_top_header_nav_above_filter','');?>
        <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ));?>
        <?php if (function_exists('dynamic_sidebar') ){ dynamic_sidebar('top_navigation');}?>
        <?php apply_filters('DDBWP_top_header_nav_below_filter','');?>
        </div></div>
    <?php
	}
}
add_action('DDBWP_get_top_header_navigation','DDBWP_top_header_navigation_content');


/************************************
//FUNCTION NAME : DDBWP_show_facebook_button_action
//ARGUMENTS : None
//RETURNS : Facebook Button Detail page - Action Hook
***************************************/
function DDBWP_show_facebook_button_action()
{
	if(DDBWP_is_facebook_button())
	{
		if (apply_filters('DDBWP_facebook_button_script', true))
		{
			global $post;
		?>
      <div class="flike"> <iframe src="https://www.facebook.com/plugins/like.php?app_id=231052570273376&amp;href=<?php the_permalink() ?>&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>
        <?php	
		}
	}
}add_action('DDBWP_show_facebook_button','DDBWP_show_facebook_button_action');


/************************************
//FUNCTION NAME : DDBWP_show_twitter_button_action
//ARGUMENTS : None
//RETURNS : Twitter Button Detail page - Action Hook
***************************************/
function DDBWP_show_twitter_button_action()
{
	if(DDBWP_is_tweet_button())
	{
		if (apply_filters('DDBWP_tweet_button_script', true))
		{
		?>
        <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal"><?php _e('Tweet','ddb_wp');?></a>
		<script type="text/javascript" src="https://platform.twitter.com/widgets.js"></script>
        <?php	
		}
	}
}
add_action('DDBWP_show_twitter_button','DDBWP_show_twitter_button_action');


/************************************
//FUNCTION NAME : DDBWP_add_site_logo
//ARGUMENTS : None
//RETURNS : Text as site logo with description
***************************************/
function DDBWP_add_site_logo()
{
	if (DDBWP_is_show_blog_title()) 
	{ 
		if ( is_home()){
			echo apply_filters('DDBWP_blog_title_text','<div class="site-title"><h1><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			echo apply_filters('DDBWP_blog_title_text','<div class="site-title"><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}
	}else
	{
		echo DDBWP_get_site_logo();
	}	
}
add_action('DDBWP_site_logo','DDBWP_add_site_logo'); //site logo action + filters

/************************************
//FUNCTION NAME : DDBWP_get_site_logo
//ARGUMENTS : None
//RETURNS : Site Header logo with Hyper link
***************************************/
function DDBWP_get_site_logo() {
	if(get_option('ddbwpthemes_logo_url'))
	{
		$logo_url = get_option('ddbwpthemes_logo_url');	
	}else
	{
		$logo_url = DDB_PUGIN_URL.'images/logo.png';
	}
    if($logo_url)
	{		
		$return_str = '<a href="'.get_option('home').'/">';
		$return_str .= '<img src="'.apply_filters('DDBWP_logo',$logo_url).'" alt="" />';
		$return_str .= '</a>';
		if ( is_home()){
			$return_str .=apply_filters('DDBWP_blog_title_text','<div class="site-title none"><h1><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a></h1> 
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}else{
			$return_str .=apply_filters('DDBWP_blog_title_text','<div class="site-title none" ><a href="'.get_option('home').'/">'.get_bloginfo( 'name', 'display' ).'</a>
		<p class="site-description">'. get_bloginfo('description', 'display').'</p></div>');
		}	
	}
    return apply_filters( 'DDBWP_get_site_logo', $return_str );
}


/************************************
//FUNCTION NAME : DDBWP_home_page_slider
//ARGUMENTS : None
//RETURNS : Widgets of Slider Above,Home Slider and Slider Below for home page
***************************************/
function DDBWP_home_page_slider()
{
	do_action('DDBWP_slider_above');
	if (apply_filters('DDBWP_home_page_slider_filter', true))
	{
		if (function_exists('dynamic_sidebar')){ dynamic_sidebar('home_slider'); }
	}
	do_action('DDBWP_slider_below');
}
/************************************
//FUNCTION NAME : get_currency_sym
//ARGUMENTS : None
//RETURNS : Currency symbol for the system
***************************************/
if(!function_exists('get_currency_sym'))
{
	function get_post_currency_sym($postid= NULL)
	{
		global $post;
		if(empty($postid))
			$postid = $post->ID;
			
		$currency = array(
						'ALL'=>'&#76;&#101;&#107;',
						'AFN'=>'&#1547;',
						'ARS'=>'&#36;',
						'AWG'=>'&#402;',
						'AUD'=>'&#36;',
						'AZN'=>'&#1084;&#1072;&#1085;',
						'BSD'=>'&#36;',
						'BBD'=>'&#36;',
						'BYR'=>'&#112;&#46;',
						'BZD'=>'&#66;&#90;&#36;',
						'BMD'=>'&#36;',
						'BOB'=>'&#36;&#98;',
						'BAM'=>'&#75;&#77;',
						'BWP'=>'&#80;',
						'BGN'=>'&#1083;&#1074;',
						'BRL'=>'&#82;&#36;',
						'BND'=>'&#36;',
						'KHR'=>'&#6107;',
						'CAD'=>'&#36;',
						'KYD'=>'&#36;',
						'CLP'=>'&#36;',
						'CNY'=>'&#165;',
						'COP'=>'&#36;',
						'CRC'=>'&#8353;',
						'HRK'=>'&#107;&#110;',
						'CUP'=>'&#8369;',
						'CZK'=>'&#75;&#269;',
						'DKK'=>'&#107;&#114;',
						'DOP'=>'&#82;&#68;&#36;',
						'XCD'=>'&#36;',
						'EGP'=>'&#163;',
						'SVC'=>'&#36;',
						'EEK'=>'&#107;&#114;',
						'EUR'=>'&#8364;',
						'FKP'=>'&#163;',
						'FJD'=>'&#36;',
						'GHC'=>'&#162;',
						'GIP'=>'&#163;',
						'GTQ'=>'&#81;',
						'GGP'=>'&#163;',
						'GYD'=>'&#36;',
						'HNL'=>'&#76;',
						'HKD'=>'&#36;',
						'HUF'=>'&#70;&#116;',
						'ISK'=>'&#107;&#114;',
						'INR'=>'',
						'IDR'=>'&#82;&#112;',
						'IRR'=>'&#65020;',
						'IMP'=>'&#163;',
						'ILS'=>'&#8362;',
						'JMD'=>'&#74;&#36;',
						'JPY'=>'&#165;',
						'JEP'=>'&#163;',
						'KZT'=>'&#1083;&#1074;',
						'KPW'=>'&#8361;',
						'KRW'=>'&#8361;',
						'KGS'=>'&#1083;&#1074;',
						'LAK'=>'&#8365;',
						'LVL'=>'&#76;&#115;',
						'LBP'=>'&#163;',
						'LRD'=>'&#36;',
						'LTL'=>'&#76;&#116;',
						'MKD'=>'&#1076;&#1077;&#1085;',
						'MYR'=>'&#82;&#77;',
						'MUR'=>'&#8360;',
						'MXN'=>'&#36;',
						'MNT'=>'&#8366;',
						'MZN'=>'&#77;&#84;',
						'NAD'=>'&#36;',
						'NPR'=>'&#8360;',
						'ANG'=>'&#402;',
						'NZD'=>'&#36;',
						'NIO'=>'&#67;&#36;',
						'NGN'=>'&#8358;',
						'KPW'=>'&#8361;',
						'NOK'=>'&#107;&#114;',
						'OMR'=>'&#65020;',
						'PKR'=>'&#8360;',
						'PAB'=>'&#66;&#47;&#46;',
						'PYG'=>'&#71;&#115;',
						'PEN'=>'&#83;&#47;&#46;',
						'PHP'=>'&#8369;',
						'PLN'=>'&#122;&#322;',
						'QAR'=>'&#65020;',
						'RON'=>'&#108;&#101;&#105;',
						'RUB'=>'&#1088;&#1091;&#1073;',
						'SHP'=>'&#163;',
						'SAR'=>'&#65020;',
						'RSD'=>'&#1044;&#1080;&#1085;&#46;',
						'SCR'=>'&#8360;',
						'SGD'=>'&#36;',
						'SBD'=>'&#36;',
						'SOS'=>'&#83;',
						'ZAR'=>'&#82;',
						'KRW'=>'&#8361;',
						'LKR'=>'&#8360;',
						'SEK'=>'&#107;&#114;',
						'CHF'=>'&#67;&#72;&#70;',
						'SRD'=>'&#36;',
						'SYP'=>'&#163;',
						'TWD'=>'&#78;&#84;&#36;',
						'THB'=>'&#3647;',
						'TTD'=>'&#84;&#84;&#36;',
						'TRY'=>'',
						'TRL'=>'&#8356;',
						'TVD'=>'&#36;',
						'UAH'=>'&#8372;',
						'GBP'=>'&#163;',
						'USD'=>'&#36;',
						'UYU'=>'&#36;&#85;',
						'UZS'=>'&#1083;&#1074;',
						'VEF'=>'&#66;&#115;',
						'VND'=>'&#8363;',
						'YER'=>'&#65020;',
						'ZWD'=>'&#90;&#36;'
						);
			$currency_code = get_post_meta($postid,'currency',true);
			$currency_symbol =  empty($currency_code)?get_currency_sym():$currency[$currency_code];
			return $currency_symbol;
	}
}

/************************************
//FUNCTION NAME : get_currency_sym
//ARGUMENTS : None
//RETURNS : Currency symbol for the system
***************************************/
if(!function_exists('get_currency_sym'))
{
	function get_currency_sym()
	{
		
		$currency = array(
						'ALL'=>'&#76;&#101;&#107;',
						'AFN'=>'&#1547;',
						'ARS'=>'&#36;',
						'AWG'=>'&#402;',
						'AUD'=>'&#36;',
						'AZN'=>'&#1084;&#1072;&#1085;',
						'BSD'=>'&#36;',
						'BBD'=>'&#36;',
						'BYR'=>'&#112;&#46;',
						'BZD'=>'&#66;&#90;&#36;',
						'BMD'=>'&#36;',
						'BOB'=>'&#36;&#98;',
						'BAM'=>'&#75;&#77;',
						'BWP'=>'&#80;',
						'BGN'=>'&#1083;&#1074;',
						'BRL'=>'&#82;&#36;',
						'BND'=>'&#36;',
						'KHR'=>'&#6107;',
						'CAD'=>'&#36;',
						'KYD'=>'&#36;',
						'CLP'=>'&#36;',
						'CNY'=>'&#165;',
						'COP'=>'&#36;',
						'CRC'=>'&#8353;',
						'HRK'=>'&#107;&#110;',
						'CUP'=>'&#8369;',
						'CZK'=>'&#75;&#269;',
						'DKK'=>'&#107;&#114;',
						'DOP'=>'&#82;&#68;&#36;',
						'XCD'=>'&#36;',
						'EGP'=>'&#163;',
						'SVC'=>'&#36;',
						'EEK'=>'&#107;&#114;',
						'EUR'=>'&#8364;',
						'FKP'=>'&#163;',
						'FJD'=>'&#36;',
						'GHC'=>'&#162;',
						'GIP'=>'&#163;',
						'GTQ'=>'&#81;',
						'GGP'=>'&#163;',
						'GYD'=>'&#36;',
						'HNL'=>'&#76;',
						'HKD'=>'&#36;',
						'HUF'=>'&#70;&#116;',
						'ISK'=>'&#107;&#114;',
						'INR'=>'',
						'IDR'=>'&#82;&#112;',
						'IRR'=>'&#65020;',
						'IMP'=>'&#163;',
						'ILS'=>'&#8362;',
						'JMD'=>'&#74;&#36;',
						'JPY'=>'&#165;',
						'JEP'=>'&#163;',
						'KZT'=>'&#1083;&#1074;',
						'KPW'=>'&#8361;',
						'KRW'=>'&#8361;',
						'KGS'=>'&#1083;&#1074;',
						'LAK'=>'&#8365;',
						'LVL'=>'&#76;&#115;',
						'LBP'=>'&#163;',
						'LRD'=>'&#36;',
						'LTL'=>'&#76;&#116;',
						'MKD'=>'&#1076;&#1077;&#1085;',
						'MYR'=>'&#82;&#77;',
						'MUR'=>'&#8360;',
						'MXN'=>'&#36;',
						'MNT'=>'&#8366;',
						'MZN'=>'&#77;&#84;',
						'NAD'=>'&#36;',
						'NPR'=>'&#8360;',
						'ANG'=>'&#402;',
						'NZD'=>'&#36;',
						'NIO'=>'&#67;&#36;',
						'NGN'=>'&#8358;',
						'KPW'=>'&#8361;',
						'NOK'=>'&#107;&#114;',
						'OMR'=>'&#65020;',
						'PKR'=>'&#8360;',
						'PAB'=>'&#66;&#47;&#46;',
						'PYG'=>'&#71;&#115;',
						'PEN'=>'&#83;&#47;&#46;',
						'PHP'=>'&#8369;',
						'PLN'=>'&#122;&#322;',
						'QAR'=>'&#65020;',
						'RON'=>'&#108;&#101;&#105;',
						'RUB'=>'&#1088;&#1091;&#1073;',
						'SHP'=>'&#163;',
						'SAR'=>'&#65020;',
						'RSD'=>'&#1044;&#1080;&#1085;&#46;',
						'SCR'=>'&#8360;',
						'SGD'=>'&#36;',
						'SBD'=>'&#36;',
						'SOS'=>'&#83;',
						'ZAR'=>'&#82;',
						'KRW'=>'&#8361;',
						'LKR'=>'&#8360;',
						'SEK'=>'&#107;&#114;',
						'CHF'=>'&#67;&#72;&#70;',
						'SRD'=>'&#36;',
						'SYP'=>'&#163;',
						'TWD'=>'&#78;&#84;&#36;',
						'THB'=>'&#3647;',
						'TTD'=>'&#84;&#84;&#36;',
						'TRY'=>'',
						'TRL'=>'&#8356;',
						'TVD'=>'&#36;',
						'UAH'=>'&#8372;',
						'GBP'=>'&#163;',
						'USD'=>'&#36;',
						'UYU'=>'&#36;&#85;',
						'UZS'=>'&#1083;&#1074;',
						'VEF'=>'&#66;&#115;',
						'VND'=>'&#8363;',
						'YER'=>'&#65020;',
						'ZWD'=>'&#90;&#36;'
						);
		if(get_option('ddbwpthemes_default_currency'))
		{
			$currency_format = get_option('ddbwpthemes_default_currency');
			list($currency_code, $currency_name) = explode('-',$currency_format);
			return $currency[strtoupper($currency_code)];
		}else{
	
			return $currency['USD'];
			}
	}
}

/************************************
//FUNCTION NAME : get_currency_code
//ARGUMENTS : None
//RETURNS : Currency code for the system
***************************************/
if(!function_exists('get_currency_code'))
{
	function get_currency_code()
	{
		if(get_option('ddbwpthemes_default_currency'))
		{
			return get_option('ddbwpthemes_default_currency');	
		} else {
			return 'USD';
		}
	}
}


function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}




function is_wp_admin()
{
	if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	{
		return true;
	}
	return false;
}

if(!function_exists('wp_pagenavi'))
{
	function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {
	
		global $request, $posts_per_page, $wpdb, $paged, $totalpost_count, $posts_per_page_homepage;
		if($posts_per_page_homepage)
		{
			$posts_per_page = $posts_per_page_homepage;
		}
		if(empty($prelabel)) {
			$prelabel  = '<strong>&laquo;</strong>';
		}
		if(empty($nxtlabel)) {
			$nxtlabel = '<strong>&raquo;</strong>';
		}
		$half_pages_to_show = round($pages_to_show/2);
		if (!is_single()) {
			if(is_tag()) {
				preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
			} elseif (!is_category()) {
				preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);	
			} else {
				preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
			}
			$fromwhere = $matches[1];
			$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
			
		}
		if($totalpost_count)
		{
			$numposts = $totalpost_count;
		}
		$max_page = ceil($numposts /$posts_per_page);
			if(empty($paged)) {
				$paged = 1;
			}
			if($max_page > 1 || $always_show) {
				echo "$before <div class='Navi'>";
				if ($paged >= ($pages_to_show-1)) {
					echo '<a href="'.str_replace('&','&amp;',str_replace('&','&amp;',get_pagenum_link())).'">&laquo; First</a>';
				}
				previous_posts_link($prelabel);
				for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
					if ($i >= 1 && $i <= $max_page) {
						if($i == $paged) {
							echo "<strong class='on'>$i</strong>";
						} else {
							echo ' <a href="'.str_replace('&','&amp;',get_pagenum_link($i)).'">'.$i.'</a> ';
						}
					}
				}
				next_posts_link($nxtlabel, $max_page);
				if (($paged+$half_pages_to_show) < ($max_page)) {
					echo '<a href="'.str_replace('&','&amp;',get_pagenum_link($max_page)).'">Last &raquo;</a>';
				}
				echo "</div> $after";
			}
	}
}



add_action("admin_head", "DDBWP_add_admin_custom_css");
function DDBWP_add_admin_custom_css()
{?>
 <link rel="stylesheet" type="text/css" media="all" href="<?php echo DDB_PUGIN_URL; ?>admin/admin_style.css" />
<?php
}
?>