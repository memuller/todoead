<?php
// Excerpt length
function bm_better_excerpt($length, $ellipsis) {
$text = get_the_content();
$text = strip_tags($text);
$text = substr($text, 0, $length);
$text = substr($text, 0, strrpos($text, " "));
$text = $text.$ellipsis;
return $text;
}
///////////NEW FUNCTIONS  START//////
function bdw_get_images($iPostID,$img_size='thumb',$no_images='') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$counter = 0;
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
			}
			$counter++;
			if($no_images!='' && $counter==$no_images)
			{
				break;	
			}
	   }
	  return $return_arr;
	}
}

function get_site_emailId()
{
	
	if(get_option('ddbwpthemes_site_email'))
	{
		return get_option('ddbwpthemes_site_email');	
	}
	return get_option('admin_email');
}
function get_site_emailName()
{
	
	if(get_option('ddbwpthemes_site_name'))
	{
		return stripslashes(get_option('ddbwpthemes_site_name'));	
	}
	return stripslashes(get_option('blogname'));
}

/************************************
//FUNCTION NAME : commentslist
//ARGUMENTS :comment data, arguments,depth level for comments reply
//RETURNS : Comment listing format
***************************************/
function commentslist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
    
    
   <li >
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?> >
    <div class="comment_left"> <?php echo get_avatar($comment, 45, DDB_PUGIN_URL.'/images/no-avatar.png'); ?> </div>
    <div class="comment-text">
      <div class="comment-meta">
        <?php printf(__('<p class="comment-author"><span>%s</span></p>','ddb_wp'), get_comment_author_link()) ?>
        
        
        <p class="comment-date"> &nbsp;~  <?php comment_date('n-j-Y'); ?> at <?php comment_time('H:i:s'); ?></p>
        
        <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
     
       
      <div class="text">
      
      	 <?php if ($comment->comment_approved == '0') : ?>
      
        <?php _e('Your comment is awaiting moderation.','ddb_wp') ?>
     
      <?php endif; ?>
      
      <?php comment_text() ?>
     </div>
     
    </div>
  </div>
    
	
    
<?php
}


// ---------------------------------------------------------------------- ///
//Shortcodes add --------------------------------------------------------
//----------------------------------------------------------------------- /// 

// Shortcodes - Messages -------------------------------------------------------- //
function message_download( $atts, $content = null ) {
   return '<p class="download">' . $content . '</p>';
}
add_shortcode( 'Download', 'message_download' );

function message_alert( $atts, $content = null ) {
   return '<p class="alert">' . $content . '</p>';
}
add_shortcode( 'Alert', 'message_alert' );

function message_note( $atts, $content = null ) {
   return '<p class="note">' . $content . '</p>';
}
add_shortcode( 'Note', 'message_note' );


function message_info( $atts, $content = null ) {
   return '<p class="info">' . $content . '</p>';
}
add_shortcode( 'Info', 'message_info' );


// Shortcodes - About Author -------------------------------------------------------- //

function about_author( $atts, $content = null ) {
   return '<div class="about_author">' . $content . '</p></div>';
}
add_shortcode( 'Author Info', 'about_author' );


function icon_list_view( $atts, $content = null ) {
   return '<div class="check_list">' . $content . '</p></div>';
}
add_shortcode( 'Icon List', 'icon_list_view' );


// Shortcodes - Boxes -------------------------------------------------------- //

function normal_box( $atts, $content = null ) {
   return '<div class="boxes normal_box">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box', 'normal_box' );

function warning_box( $atts, $content = null ) {
   return '<div class="boxes warning_box">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box', 'warning_box' );

function about_box( $atts, $content = null ) {
   return '<div class="boxes about_box">' . $content . '</p></div>';
}
add_shortcode( 'About_Box', 'about_box' );

function download_box( $atts, $content = null ) {
   return '<div class="boxes download_box">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box', 'download_box' );

function info_box( $atts, $content = null ) {
   return '<div class="boxes info_box">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box', 'info_box' );


function alert_box( $atts, $content = null ) {
   return '<div class="boxes alert_box">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box', 'alert_box' );



// Shortcodes - Boxes - Equal -------------------------------------------------------- //

function normal_box_equal( $atts, $content = null ) {
   return '<div class="boxes normal_box small">' . $content . '</p></div>';
}
add_shortcode( 'Normal_Box_Equal', 'normal_box_equal' );

function warning_box_equal( $atts, $content = null ) {
   return '<div class="boxes warning_box small">' . $content . '</p></div>';
}
add_shortcode( 'Warning_Box_Equal', 'warning_box_equal' );

function about_box_equal( $atts, $content = null ) {
   return '<div class="boxes about_box small">' . $content . '</p></div>';
}
add_shortcode( 'About_Box_Equal', 'about_box' );

function download_box_equal( $atts, $content = null ) {
   return '<div class="boxes download_box small">' . $content . '</p></div>';
}
add_shortcode( 'Download_Box_Equal', 'download_box_equal' );

function info_box_equal( $atts, $content = null ) {
   return '<div class="boxes info_box small">' . $content . '</p></div>';
}
add_shortcode( 'Info_Box_Equal', 'info_box_equal' );


function alert_box_equal( $atts, $content = null ) {
   return '<div class="boxes alert_box small">' . $content . '</p></div>';
}
add_shortcode( 'Alert_Box_Equal', 'alert_box_equal' );


// Shortcodes - Content Columns -------------------------------------------------------- //

function one_half_column( $atts, $content = null ) {
   return '<div class="one_half_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Half', 'one_half_column' );

function one_half_last( $atts, $content = null ) {
   return '<div class="one_half_column right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Half_Last', 'one_half_last' );


function one_third_column( $atts, $content = null ) {
   return '<div class="one_third_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Third', 'one_third_column' );

function one_third_column_last( $atts, $content = null ) {
   return '<div class="one_third_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Third_Last', 'one_third_column_last' );


function one_fourth_column( $atts, $content = null ) {
   return '<div class="one_fourth_column left">' . $content . '</p></div>';
}
add_shortcode( 'One_Fourth', 'one_fourth_column' );

function one_fourth_column_last( $atts, $content = null ) {
   return '<div class="one_fourth_column_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'One_Fourth_Last', 'one_fourth_column_last' );


function two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds left">' . $content . '</p></div>';
}
add_shortcode( 'Two_Third', 'two_thirds' );

function two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds_last right">' . $content . '</p></div><div class="clear_spacer clearfix"></div>';
}
add_shortcode( 'Two_Third_Last', 'two_thirds_last' );


function dropcaps( $atts, $content = null ) {
   return '<p class="dropcaps">' . $content . '</p>';
}
add_shortcode( 'Dropcaps', 'dropcaps' );


// Shortcodes - Small Buttons -------------------------------------------------------- //

function small_button( $atts, $content ) {
 return '<div class="small_button '.$atts['class'].'">' . $content . '</div>';
}
add_shortcode( 'Small_Button', 'small_button' );




// filters add -------------///


add_filter('DDBWP_top_header_navigation_content','DDBWP_top_header_nav_above_fun_content');
function DDBWP_top_header_nav_above_fun_content(){
	echo 'header';
}


add_filter('DDBWP_top_header_nav_above_filter','DDBWP_top_header_nav_above_fun');
function DDBWP_top_header_nav_above_fun()
{

	

}



add_filter('DDBWP_top_header_nav_below_filter','DDBWP_top_header_nav_below_fun');
function DDBWP_top_header_nav_below_fun()
{
?> 
    <ul class="member_link">
	 	  <li><a href="<?php echo site_url();?>/?dwtype=taxonomy_all_deal_tab"><?php _e('Deals','ddb_wp');?></a>
		<ul>
	
	  <?php $cat_args = array('orderby' => 'name','taxonomy'=>'seller_category','title_li' => __( '' ), ); 
	  if(wp_list_categories(apply_filters('widget_categories_args', $cat_args)) != ""){
	  ?>
	
			 <?php wp_list_categories(apply_filters('widget_categories_args', $cat_args));  ?>
		
		<?php } ?>
		</ul>
	  </li>  
    </ul>
	
<?php
}

function getCurrencyDropdown($default){
	$option = 'USD-US Dollar,GBP-Pound,JPY-Japanese Yen,EUR-Euro,AUD-Austrailian Dollar,CAD-Canadian Dollar,NZD-New Zealand Dollar,CHF-Swiss Franc,HKD-Hong Kong Dollar,SGD-Singapore Dollar,SEK-Swedish Krona,DKK-Danish Krone,PLN-Polish Zloty,NOK-Norwegian Krone,HUF-Hungarian Forint,CZK-Czech Koruna,ILS-Israeli Shekel,MXN-Mexican Peso,PHP-Philippine Pesos,TWD-Taiwan New Dollars,THB-Thai Baht,BRL-Brazilian Real,MYR-Malaysian Ringgits';
	$items = explode(',',$option);
	$html ='';
	foreach($items as $item){
		list($val, $text) = explode('-',$item);
		$html .= '<option value="'.$val.'" ';
		$html .= ($val == $default)?'selected="selected"':'';
		$html .= '>'.$text.'</option>';
	}
	return $html;
}

function save_seller_meta($post_id) {
    global $current_user;
	/* in production code, $slug should be set only once in the plugin,
       preferably as a class property, rather than in each function that needs it.
     */
    $slug = 'seller';

    /* check whether anything should be done */
    //$_POST += array("{$slug}_edit_nonce" => '');
    if ( $slug != $_POST['post_type'] ) {
        return;
    }
    if ( !current_user_can( 'publish_posts', $post_id ) ) {
		if ( !wp_is_post_revision( $post_id ) ) {
			
			$post_title = get_the_title( $post_id );
			$post_url = get_permalink( $post_id );
			
      		$message = 'Hello Admin, <br/><br/>';
			$message .= '"'.$current_user->user_firstname.' '.$current_user->user_lastname.'" using '.get_bloginfo('name').' has created a new deal. <br/>';
			$message .= 'Please review the deal to either Accept or Reject . <br/><br/>';
			$message .= 'Deal Name : '."<a href='". $post_url. "'>" .$post_title. "</a>".' <br/><br/>';
			$message .= 'Thanks,<br/>The SpotlightYour Team"';
			
			add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
			
			wp_mail(get_bloginfo('admin_email'), 'New Deal Submitted By Merchant', $message);	
		}
		return;
    }
    
}

add_action( 'save_post', 'save_seller_meta');
?>