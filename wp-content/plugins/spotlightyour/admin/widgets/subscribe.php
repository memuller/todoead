<?php
// =============================== Feedburner Subscribe widget ======================================
class usersubscribe extends WP_Widget {
	function usersubscribe() {
	//Constructor
		$widget_ops = array('classname' => 'widget UserSubscribe', 'description' => 'User will subscribe here' );		
		$this->WP_Widget('widget_subscribe', apply_filters('DDBWP_subscribe_widget_title_filter','T &rarr; User Subscribe'), $widget_ops);
	}
	//
	function widget($args, $instance) {
		$theme = get_option('ddbwpthemes_alt_stylesheet');
		//ddbwp_pr($instance); 
	//	print_r($this); exit;
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
		
		$subscriber_page = get_page_by_title( "E-mail Subscriptions" );
		
		
?>
    	<div class="deal-subscribe clear">
      <div class="top"></div>
      <div id="deal-subscribe-body" class="body"> 
		<?php if ( $text <> "" ) { ?>	 
            <p><?php echo $text; ?> </p>
        <?php } ?>
      <form accept-charset="utf-8" action="<?php echo get_permalink($subscriber_page->ID);?>" method="post" id="deal-subscribe-form">
      <input name="seller_category" value="<?php echo $id?>" type="hidden" />      
      <table class="address" width="20%">
          <tbody><tr>
            <td><input type="text" id="deal-subscribe-form-email" class="f-text" name="data[Subscribe][email]"></td>
            <td><input type="image" value="Submit" src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/button-subscribe.gif"></td>
          </tr>
        </tbody></table>
        <p class="text"><?php _e('Please enter your e-mail address to subscribe','ddb_wp')?>.<br>
          <span class="required">*</span> <?php _e('You can unsubscribe','ddb_wp')?><br>
          <?php _e('at any time','ddb_wp')?></p>
      </form></div>
       </div>    
<?php
	}
	
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['seller_category'] = strip_tags($new_instance['seller_category']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);		
		return $instance;
	}
	
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '','seller_category' => '' ) );		
		$seller_category = strip_tags($instance['seller_category']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
		
		$args = array(
                             'show_option_all' => "All Cities",
                             'taxonomy' => CUSTOM_CATEGORY_TYPE1,
                             'name'     => CUSTOM_CATEGORY_TYPE1
                         );
 ?>
 <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:','ddb_wp');?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('City :','ddb_wp'); wp_dropdown_categories($args);?> </label></p>
  <p><label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Short Description:','ddb_wp');?> <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo attribute_escape($text); ?></textarea></label></p>
<?php
	}}
	
	// register Foo_Widget widget
add_action( 'widgets_init', create_function( '', 'register_widget( "usersubscribe" );' ) );
// =============================== Feedburner Subscribe widget ======================================
class subscribe extends WP_Widget {
	function subscribe() {
	//Constructor
		$widget_ops = array('classname' => 'widget Subscribe', 'description' => apply_filters('DDBWP_subscribe_widget_desc_filter','Subscribe Widget') );		
		$this->WP_Widget('widget_subscribe', apply_filters('DDBWP_subscribe_widget_title_filter','T &rarr; Subscribe'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
?>
    	<div class="widget newsletter clear" >
    <h3> 
     <?php if($title){?><span class="title"><?php echo $title; ?></span> <?php }?> 
     <a href="<?php if($id){echo 'http://feeds2.feedburner.com/'.$id;}else{bloginfo('rss_url');} ?>" >
      <img  src="<?php echo DDB_PUGIN_URL;?>/admin/widgets/widget_images/i_rss_s.png" alt="" class="i_rss"  /> </a> </h3>
	<?php if ( $text <> "" ) { ?>	 
         <p><?php echo $text; ?> </p>
    <?php } ?>
 		<form class="newsletter_form "  action="http://feedburner.google.com/fb/a/mailverify" method="post"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return false;">    
      
       <input type="text" class="field" value="<?php _e('Enter Email Address','ddb_wp')?>" onfocus="if (this.value == '<?php _e('Enter Email Address','ddb_wp')?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter Email Address','ddb_wp')?>';}" name="email"/>
      <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
     <input class="btn_submit" type="submit" name="submit" value="" /> 
     </form>
		  </div>  <!-- #end -->
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
	}}

?>