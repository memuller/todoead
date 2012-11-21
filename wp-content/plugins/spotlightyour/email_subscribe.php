<?php 
global $table_prefix,$wpdb;
if(!function_exists('wp_upload_dir')){
		$file = dirname(__FILE__);
		$file = substr($file,0,stripos($file, "wp-content"));
		require($file . "/wp-load.php");
	}
	

$message = '';
//Form Submitted
if(isset($_REQUEST['seller_category']) && !empty($_REQUEST['seller_category'])){
			
			$user_name = $user_email = urldecode($_REQUEST['subscriber_email']);
									
			$user_id = username_exists( $user_name );

			if ( !$user_id ) {
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$user_id = wp_create_user( $user_name, $random_password, $user_email );
				
				update_user_meta($user_id, 'city_subscribed', urldecode($_REQUEST['seller_category']));		
				
				$subject = 'Email Subscription Confirmed';
				$message ='Congratulations, your account has been successfully set up for receiving daily alerts from '.get_bloginfo('name').'.<br><br>
You will be notified every time new deals are added to our site.<br><br>

Thanks,<br>
The Spotlight Team';

				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
				//$headers = 'From: '.$_POST['name'].' <'.$_POST['email'].'>' . "\r\n";
				wp_mail($user_email, $subject, $message);
				
				$message = __('Thanks for subscribing.');
			} else {				
				$message = __('<span style="color:red">You are already subscribed.</span>');	
			}
			
			if ( is_wp_error($user_id) ){
				
   				$message = __('<span style="color:red">'). $user_id->get_error_message() .__('</span>') ;
			
			}
			
}
echo $message; die;