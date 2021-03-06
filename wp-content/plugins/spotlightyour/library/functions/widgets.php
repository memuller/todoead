<?php
/********************************************************************
You can add your widgets in this file and it will affected.
This is the theme related widgets functions file where you can add you created widget code.\
The file is included in functions.php  file of theme root.
********************************************************************/
// socialbookmark - widget  ================================  ///
class socialbookmark extends WP_Widget {
		function socialbookmark() {
		//Constructor
			$widget_ops = array('classname' => 'widget Socail Media Bookmark', 'description' => __('Socail Media Bookmark') );		
			$this->WP_Widget('widget_socialbookmark', __('T &rarr; Socail Media Bookmark'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			
			$facebook_title = empty($instance['facebook_title']) ? '' : apply_filters('widget_facebook_title', $instance['facebook_title']);
			$twitter_title = empty($instance['twitter_title']) ? '' : apply_filters('widget_twitter_title', $instance['twitter_title']);
			$rss_title = empty($instance['rss_title']) ? '' : apply_filters('widget_rss_title', $instance['rss_title']);
			
			$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
			$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);			
			$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
			?>						
		  
				
                
		<p class="social_media">
			<?php if ( $twitter <> "" ) { ?><a href="<?php echo $twitter; ?>" class="i_twitter" title="<?php echo $twitter_title; ?>" target="_blank"><?php echo $twitter_title; ?></a><?php } ?>
            <?php if ( $facebook <> "" ) { ?><a href="<?php echo $facebook; ?>" class="i_facebook" title="<?php echo $facebook_title; ?>" target="_blank"><?php echo $facebook_title; ?></a><?php } ?>
			<?php if ( $rss <> "" ) { ?><a href="<?php echo $rss; ?>" class="i_rss" title="<?php echo $rss_title; ?>" target="_blank"><?php echo $rss_title; ?></a><?php } ?>
		</p>
				 
                    
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;	
			$instance['facebook_title'] = ($new_instance['facebook_title']);
			$instance['twitter_title'] = ($new_instance['twitter_title']);
			$instance['rss_title'] = ($new_instance['rss_title']);
			
			$instance['facebook'] = ($new_instance['facebook']);
			$instance['twitter'] = ($new_instance['twitter']);
			$instance['rss'] = ($new_instance['rss']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'facebook_title' => '','twitter_title' => '','rss_title' => '','facebook' => '','twitter' => '','rss' => '',) );		
		
			$facebook_title = ($instance['facebook_title']);
			$twitter_title = ($instance['twitter_title']);
			$rss_title = ($instance['rss_title']);
			
			$facebook = ($instance['facebook']);
			$twitter = ($instance['twitter']);
			$rss = ($instance['rss']);
	?>  
	<p><label for="<?php  echo $this->get_field_id('facebook_title'); ?>"><?php _e('Facebook Title');?>: <input class="widefat" id="<?php  echo $this->get_field_id('facebook_title'); ?>" name="<?php echo $this->get_field_name('facebook_title'); ?>" type="text" value="<?php echo attribute_escape($facebook_title); ?>" /></label></p>
	<p><label for="<?php  echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Full URL');?>: <input class="widefat" id="<?php  echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo attribute_escape($facebook); ?>" /></label></p>
	
	<p><label for="<?php  echo $this->get_field_id('twitter_title'); ?>"><?php _e('Twitter Title');?>: <input class="widefat" id="<?php  echo $this->get_field_id('twitter_title'); ?>" name="<?php echo $this->get_field_name('twitter_title'); ?>" type="text" value="<?php echo attribute_escape($twitter_title); ?>" /></label></p> 
	<p><label for="<?php  echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter Full URL');?>: <input class="widefat" id="<?php  echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo attribute_escape($twitter); ?>" /></label></p> 
	
	<p><label for="<?php  echo $this->get_field_id('rss_title'); ?>"><?php _e('RSS Title');?>: <input class="widefat" id="<?php  echo $this->get_field_id('rss_title'); ?>" name="<?php echo $this->get_field_name('rss_title'); ?>" type="text" value="<?php echo attribute_escape($rss_title); ?>" /></label></p>  
	<p><label for="<?php  echo $this->get_field_id('rss'); ?>"><?php _e('RSS Full URL');?>: <input class="widefat" id="<?php  echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo attribute_escape($rss); ?>" /></label></p>  
	
	<?php
	}
}




// Login - widget  ================================  ///
class loginuser extends WP_Widget {
		function loginuser() {
		//Constructor
			$widget_ops = array('classname' => 'widget Header Login User', 'description' => __('Header Login User') );		
			$this->WP_Widget('widget_loginuser', __('T &rarr; Header Login User'), $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			
			
			?>						
	<div class="login_area"> 
	<?php
    global $current_user;
    if($current_user->data->ID)
    {
    ?>
   
	<?php _e('Welcome ','ddb_wp'); ?> <a href="<?php echo get_author_posts_url($current_user->data->ID);?>"><?php echo $current_user->data->display_name;?></a> <span> | </span> <?php 	echo apply_filters('DDBWP_login_widget_logoutlink_filter','<a href="'.wp_logout_url(get_option('siteurl')).'">'.__('Logout','ddb_wp').'</a>');

		
    }else
    {
    ?>
   <?php _e('Welcome Guest','ddb_wp');?><span> |</span> <a href="<?php echo site_url();?>/?dwtype=login">Sign In</a> <span>|</span> <a href="<?php echo site_url();?>/?dwtype=login">Sign Up </a>
    <?php	
    }
    ?>
    </div>
                
		
				 
                    
		<?php
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;	
			
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array( 'facebook_title' => '',) );		
		
			
	?>  
	<p></p>  
	
	<?php
	}
}



// =============================== Feedburner Get New Deal every day  widget ======================================
class get_new_deal extends WP_Widget {
	function get_new_deal() {
	//Constructor
		$widget_ops = array('classname' => 'widget get_new_deal', 'description' => apply_filters('DDBWP_get_new_deal_widget_desc_filter','Get New Deals Every Day Widget') );		
		$this->WP_Widget('widget_get_new_deal', apply_filters('DDBWP_get_new_deal_widget_title_filter','T &rarr; Get New Deals Every Day'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
?>



<div class="subscribe_box">
                <div class="left    ">
                    <h3><?php if($title){?><?php echo $title; ?><?php }?> </h3>
                   <?php if ( $text <> "" ) { ?><p><?php echo $text; ?></p><?php } ?>
                </div>
                <div class="subscribe_bg">
                     <form class="subscribe_form"  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"> 
                        <input type="text" class="text_bg"  id="subscribe_email" value="<?php _e('Enter Email Address','ddb_wp')?>" onfocus="if (this.value == '<?php _e('Enter Email Address')?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter Email Address','ddb_wp')?>';}" name="email" />
                        <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
     <input class="subscribe_submit" type="submit" name="submit" value="Subscribe Now!" /> 
                    </form>
                      
               </div>
               <div class="btm_border"></div>
            </div> <!-- subscribe box #end -->



    	
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);		
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '','id' => '' ) );		
		$id = strip_tags($instance['id']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
 ?>
 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','ddb_wp');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Feedburner ID (ex :- ddb_wp):','ddb_wp');?> <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Short Description:','ddb_wp');?> <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo attribute_escape($text); ?></textarea></label></p>
<?php
	}
}


// =============================== Subscriber  widget ======================================
class get_subscribe_option extends WP_Widget {
	function get_subscribe_option() {
	//Constructor
		$widget_ops = array('classname' => 'widget get_subscribe_option', 'description' => apply_filters('DDBWP_get_subscribe_option_widget_desc_filter','Subscribe Option Widget') );		
		$this->WP_Widget('widget_get_subscribe_option', apply_filters('DDBWP_get_subscribe_option_widget_desc_filter','T &rarr; Subscribe Option'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$opt_subscrib = empty($instance['opt_subscrib']) ? '' : apply_filters('widget_opt_subscrib', $instance['opt_subscrib']);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
?>


             <?php /*?>  <div class="widget newsletter" >
                    <h3><?php if($title){?><?php echo $title; ?><?php }?> </h3>
                   <?php if ( $text <> "" ) { ?><p><?php echo $text; ?></p><?php } ?>
                </div><?php */?>
                
					<?php 
					
					if($opt_subscrib == 'mailchimp') {
						if (function_exists (mailchimpSF_signup_form)) mailchimpSF_signup_form();
					} else if($opt_subscrib == 'constant_contact') {
						 if (function_exists (gConstantcontact)) gConstantcontact(); 
					} else {?>
					<div class="widget newsletter" >
        
					<h3><?php _e('Subscribe','ddb_wp');?></h3>
                    <form   action="http://feedburner.google.com/fb/a/mailverify" method="post"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return false;">
                        <input type="text" class="text_bg"  id="subscribe_text" value="<?php _e('Enter Email Address','ddb_wp')?>" 
                        onfocus="if (this.value == '<?php _e('Enter Email Address')?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter Email Address','ddb_wp')?>';}" />
                        <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
     				<input class="subscribe_submit" type="submit" name="submit" value="Subscribe Now!" /> 
                    </form>	</div>  <!-- #end -->
                    <?php } ?>
               <!-- subscribe box #end -->



    	
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['opt_subscrib'] = strip_tags($new_instance['opt_subscrib']);
		$instance['id'] = strip_tags($new_instance['id']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'opt_subscrib' => '','id' => '' ) );		
		$id = strip_tags($instance['id']);
		$opt_subscrib = strip_tags($instance['opt_subscrib']);
		if($opt_subscrib == 'mailchimp'){
			$mchecked = 'checked';
		} else if($opt_subscrib == 'constant_contact'){
			$cchecked = 'checked';
		} else {
			$dchecked = 'checked';
		}
 ?>
 <?php if (function_exists (mailchimpSF_signup_form) && plugin_is_active('mailchimp')) { ?>
<input type="radio" name="<?php echo $this->get_field_name('opt_subscrib'); ?>" value="<?php _e('mailchimp','ddb_wp')?>" <?php echo $mchecked;?>>&nbsp;<?php _e('Mail Chimp','ddb_wp')?><br /> <?php }  if (function_exists (gConstantcontact) && plugin_is_active('constant-contact')) { ?>
<input type="radio" name="<?php echo $this->get_field_name('opt_subscrib'); ?>" value="<?php _e('constant_contact','ddb_wp')?>" <?php echo $cchecked;?>>&nbsp;<?php _e('Constant Contact','ddb_wp')?><br /><?php } ?>
<input type="radio" name="<?php echo $this->get_field_name('opt_subscrib'); ?>" value="<?php _e('default','ddb_wp')?>" <?php echo $dchecked;?>>&nbsp;<?php _e('Default','ddb_wp')?><br /><br />
<p><?php _e('<strong>If you select default option then enter ID.</strong>','ddb_wp');?></p>
 <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Feedburner ID (ex :- ddb_wp):','ddb_wp');?> <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo attribute_escape($id); ?>" /></label></p>

<?php
	}
}


  // =============================== City Listing  ======================================
class categorywidget extends WP_Widget {
	function categorywidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget category', 'description' => 'category widget in sidebar','taxonomy' => 'seller_category' );		
		$this->WP_Widget('categorywidget', 'T &rarr; Formated City', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title1', $instance['title']);	
		if($title ==''){
			echo '<div class="widget"><h3>City</h3>';
		}
		else{
			echo '<div class="widget"><h3>'.$title.'</h3>';
		}
		?>	
		<div class="category_list">
			<ul>
			<?php
				$categories = wp_list_categories('title_li=&show_count=1&echo=0');
				$categories = ereg_replace('</a> \(([0-9]+)\)', ' <small>\\1</small></a>', $categories);
				echo $categories;
				?>
            </ul>
		</div>
        
        </div>
			<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = strip_tags($instance['title']);
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">City Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>       
       
<?php
	}}



 // =============================== Page - sub page listing ======================================
class subpagewidget extends WP_Widget {
	function subpagewidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Sub Page listing', 'description' => 'Sub Page listing widget in sidebar' );		
		$this->WP_Widget('subpagewidget', 'PT &rarr; Sub Page listing', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title1', $instance['title']);	
		
		?>	
        
		  <ul class="sub_page_menu">
		 <?php
  if($post->post_parent)
  $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
  else
  $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
  if ($children) { ?>
   <?php echo $children; ?>
   <?php } ?> 
        </ul>
    
        
        
			<?
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = strip_tags($instance['title']);
?>
		<?php /*?><p><label for="<?php echo $this->get_field_id('title'); ?>">City Title : <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p> <?php */?>      
       
<?php
	}}

$custom_post_type = "seller";
//======================================
class WP_Widget_Custom_Taxonomy extends WP_Widget {

	function WP_Widget_Custom_Taxonomy() {
		$widget_ops = array('classname' => 'widget_taxonomy', 'description' => 'A list or dropdown of Custom Taxonomy' );		
		$this->WP_Widget('widget_taxonomy', 'PT &rarr; Custom Taxonomy', $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Cities' ) : $instance['title'], $instance, $this->id_base);
		$c = $instance['count'] ? '1' : '0';
		$h = $instance['hierarchical'] ? '1' : '0';
		$d = $instance['dropdown'] ? '1' : '0';
		$tn = $instance['taxonomy'] ? $instance['taxonomy'] : 'category';
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy'=>$tn, );
		if ( $d ) {
			$cat_args['show_option_none'] = __('Select City');
			wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
?>
<input type="hidden" name="category_count" id="category_count" value="<?php echo $c;?>" />
<input type="hidden" name="category_name" id="category_name" value="<?php echo $instance['taxonomy'];?>" />
<script type='text/javascript'>
/* <![CDATA[ */
	var tn = document.getElementById("category_name").value;
	var dropdown = document.getElementById("cat");
	function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
	}
	function onCatChange() {
		if ( dropdown.options[dropdown.selectedIndex].value > 0) {	
			if (tn == 'category' ){
				
			location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
			}
			if (tn == 'seller_category' ){
				
			location.href = "<?php echo home_url(); ?>/?seller_category="+dropdown.options[dropdown.selectedIndex].text;
			}
			else if (tn == 'post_tag' ) { 
				if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(/ /gi,"-");
					var tag = trim(arr[0]);
				}
				location.href = "<?php echo home_url(); ?>/?tag="+tag;
			}
			else if (tn == 'eventcategory' ) {
if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(" ","-");
					var tag = trim(arr[0]);
				}
				location.href = "<?php echo home_url(); ?>/?eventcategory="+tag;			}
			else if (tn == 'eventtags' ) {
				if(document.getElementById("category_count").value == "" || document.getElementById("category_count").value == 0)
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var tag = str.replace(/ /gi,"-");
					
				}
				else
				{
					var str = dropdown.options[dropdown.selectedIndex].text;
					var arr = str.split("(");
					arr[0] = arr[0].replace(/ /gi,"-");
					var tag = trim(arr[0]);
				}
			location.href = "<?php echo home_url(); ?>/?eventtags="+tag;
			}
		}
	}
	dropdown.onchange = onCatChange;
/* ]]> */
</script>
<?php
		} else {
?>	<ul>
<?php
		$cat_args['title_li'] = '';
		wp_list_categories(apply_filters('widget_categories_args', $cat_args));
?>
	</ul>
<?php
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$current_taxonomy = esc_attr( $instance['taxonomy'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
		global $custom_post_type;
?>
		<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
       <p>
       <label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Select Taxonomy:' ); ?></label>
		<select id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>">
        <?php foreach ( get_object_taxonomies('post') as $taxonomy ) :
				$tax = get_taxonomy($taxonomy);
				if ( !$tax->show_tagcloud || empty($tax->labels->name) )
					continue;
		?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
		<?php endforeach; ?>
		<?php foreach ( get_object_taxonomies($custom_post_type) as $taxonomy ) :
					$tax = get_taxonomy($taxonomy);
					if ( !$tax->show_tagcloud || empty($tax->labels->name) )
						continue;
		?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $current_taxonomy) ?>><?php echo $tax->labels->name; ?></option>
		<?php endforeach; ?>
        </select>
        </p>

		<p>
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Show as dropdown' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label>
        </p>
<?php
	}

}


function DDB_register_widget(){
	register_widget('WP_Widget_Custom_Taxonomy');
	register_widget('subpagewidget');
	register_widget('categorywidget');
	register_widget('get_subscribe_option');
	register_widget('get_new_deal');
	register_widget('loginuser');
	register_widget('socialbookmark');
	register_widget('onecolumnslist');
	
}

add_action( 'widgets_init', 'DDB_register_widget' );
include_once (DDB_PUGIN_PATH . '/library/functions/deal_widget.php');

?>