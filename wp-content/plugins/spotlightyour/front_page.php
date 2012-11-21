<?php
/**************************************************************
*	This page is used to display all the Link at Front End
*
****************************************************************/
global $post;
// Use a static front page
$about = get_page_by_title( "Today's Deals" );
update_option( 'page_on_front', $about->ID );
update_option( 'show_on_front', 'page' );

if($Blog = get_page_by_title( "Blog" )){
	update_option( 'page_for_posts', $Blog->ID );
}
/*if($_REQUEST['widgetdwtype'] == 'coupon'){
	include "coupon_verification.php";
}*/
//print_r($post);
if($post->post_type == 'seller'){
	add_filter('the_tile','set_deals_title');
}

function set_deals_title($title){
	return '';	
}
function ddb_custom_header(){
	$custom_style = '';
	//Font
	$font = get_option('ddbwpthemes_fonts');
	if(!empty($font))
		$custom_style .= '$(\'*\').css("font-family","'.$font.'");';
	
	//Body Background Color
	$bcolor = get_option('ddbwpthemes_body_background_color');
	if(!empty($bcolor))
		$custom_style .= '$(\'body\').css("background-color","'.$bcolor.'");';
	
	//Body Background Image
	$bimage = get_option('ddbwpthemes_body_background_image');
	if(!empty($bimage))
		$custom_style .= '$(\'body\').css("background-image","'.$bimage.'");';
	
	//Link Color Normal
	$link_color = get_option('ddbwpthemes_link_color_normal');
	if(!empty($link_color))
		$custom_style .= '$(\'a\').css("color","'.$link_color.'");';
	
	//Body Bg Postions
	$bg_position = get_option('ddbwpthemes_body_bg_postions');
	if(!empty($bg_position))
		$custom_style .= '$(\'body\').css("background-position","'.$bg_position.'");';
	
	//Main Heading Color
	$main_heading = get_option('ddbwpthemes_main_title_color');
	if(!empty($main_heading))
		$custom_style .= '$(\'h1.content-title\').css("color","'.$main_heading.'");';
	
	//ddbwpthemes_link_color_hover
	$linkhover = get_option('ddbwpthemes_link_color_hover');
	if(!empty($linkhover))
		$custom_style .= '$("a").hover(function(e){$(this).css("color","'.$linkhover.'");}, function(e){$(this).css("color","'.$link_color.'");});';
		
	//Font
	$custom_css_allaowed = get_option('ddbwpthemes_customcss');
	
	if(!empty($custom_css_allaowed) && trim($custom_css_allaowed) == 'Activate'){		
		
?>
<script language="javascript" type="text/javascript">
$(document).ready(function(e) {	
    $('body').css('background','none');
	$('#wrapper').css('background','none');
	
	<?php	echo $custom_style;	?>
});
</script>
<?php	
	}
}

add_action('wp_head', 'ddb_add_header');


function ddb_add_header(){
	global $post;
	 $theme = get_option('ddbwpthemes_alt_stylesheet');
	// if(is_front_page() || $post->post_type == 'seller'){	
?>
<link type="text/css" href="<?php echo DDB_PUGIN_URL. 'skins/ddb_default.css'; ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo DDB_PUGIN_URL. 'skins/'.$theme.'.css'; ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo DDB_PUGIN_URL; ?>library/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />
<style>
.singular .entry-header, .singular .entry-content, .singular footer.entry-meta, .singular #comments-title{
	width:100%;
}
.singular #content, .left-sidebar.singular #content{
	margin:0 auto;
}
.entry-title{margin-left:23px;}
.entry-content{padding-top:0;}
.mail{float:left;width: 390px;}
#deals_content .enter-address {
    background: none repeat scroll 0 0 #FDFEEE;
    border: 1px solid #F3D3C4;
    margin-top: 20px;
    padding: 15px 20px 30px;
	height:140px;
}
#deal-subscribe-body input, #deal-subscribe-body select{
	margin-bottom:0;
	font-size:12px;
	color:#999;
}
.enter-address-c {
    float: left;
    font-size: 12px;
    margin-top: 22px;
}
#deals_content .hint{ width: 332px;}
.city{ padding: 10px 0;}
.signinlink a{text-transform:uppercase;}
.sbox-content{
	padding:0 10px;
	overflow:hidden;
}
.grid .content_right_inner{	width:240px;}
.singular.page .hentry{ padding:1em 0 0	}
#deal-subscribe-body{
	border:1px  #BAFAAB solid;
	border-top:none;
	margin-bottom:15px;
	-webkit-border-bottom-right-radius: 10px;
	-webkit-border-bottom-left-radius: 10px;
	-moz-border-radius-bottomright: 10px;
	-moz-border-radius-bottomleft: 10px;
	border-bottom-right-radius: 10px;
	border-bottom-left-radius: 10px;
}
.deal-subscribe .text{
	padding-left:10px;
}
</style>
<script type="text/javascript">var switchTo5x=false;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "36582ed0-0619-4d26-8117-1b7f7901111c"}); </script>

<script type="text/javascript" >
var root_path_js = '<?php echo DDB_PUGIN_URL;?>';
</script>
<script language="javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo DDB_PUGIN_URL; ?>library/js/countdown.js"></script>

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script> 

<!-- Contact Form CSS files -->
<link type='text/css' href='<?php echo DDB_PUGIN_URL; ?>/contact.css' rel='stylesheet' media='screen' />
<?php
	 //}
	 echo get_option('ddbwpthemes_scripts_header');
	 ddb_custom_header();
}

add_action('wp_footer', 'ddb_add_footer');

function ddb_add_footer(){
	echo get_option('ddbwpthemes_scripts_footer');
?>
<!-- Load JavaScript files -->
<!--<script type='text/javascript' src='<?php echo DDB_PUGIN_URL; ?>js/jquery.js'></script>-->
<script type='text/javascript' src='<?php echo DDB_PUGIN_URL; ?>js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='<?php echo DDB_PUGIN_URL; ?>js/contact.js'></script>

<?php	
}


function render_deals_items($content) {
  // assuming you have created a page/post entitled 'debug'
  global $post;
  
  if(!is_front_page()){	
	
	if($post->post_type == 'seller'){
		include "offerpage.php";
		return '';
	}
	
	$email_identifier = '[DDB-WP SubscribeDeals]';
	if(strstr($content,$email_identifier)  || is_page('E-mail Subscriptions')){
		include "email_subscription.php";
	}
	
	$merchant_identifier = '[DDB-WP Merchant-SignUp]';
	if(strstr($content,$merchant_identifier)  || is_page('Merchant SignUp')){
		include "merchant_signUp.php";
	}
	
	/*$register_identifier = '[DDB-WP SignUp]';
	if(strstr($content,$register_identifier)  || is_page('Register')){
		include "register_user.php";
	}*/
		
	return $content;  
  }else{  
      
		include "homepage.php";
		return '';
   
  }
   return str_replace('[DDB-WP TodayDeals]','',$content); 
}

add_filter( 'the_content', 'render_deals_items' );

//Share Icons
function DDBWP_share_links($post_url,$post_title){
?>
<div class="emailthis stButton_gradient">
<!--Other Share Button code-->       
<span class='st_email' displayText='Email' st_title='<?php echo $post_title; ?>' st_url='<?php echo post_url; ?>'></span>
</div>
<dl id="share_links_icon">
<?php if(get_option('ddbwpthemes_tweet_button') == 'Yes'){?>
        	<dd class="twitter">
       <!-- Twitter Share Button-->
       <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $post_url;?>" data-text="<?php $post_title;?>" data-count="none">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</dd>
 <?php }if(get_option('ddbwpthemes_facebook_button') == 'Yes'){?>           
            <dd class="facebook">
        <!--Facebook Share button-->
        <a name="fb_share"  type="button" share_url="<?php echo $post_url;?>" share_title="<?php echo $post_title;?>"></a> 
<script src="http://static.ak.fbcdn.net/connect.php/js/FB.Share" 
        type="text/javascript">
</script>
       </dd>
       <?php } ?>
       <dd class="linkedin">
       <!-- Linked IN Share Button -->
       <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
	  <script type="IN/Share" data-url="<?php echo $post_url;?>" data-title="<?php echo $post_title;?>"></script>
		</dd>
</dl>
<?php	
}
?>