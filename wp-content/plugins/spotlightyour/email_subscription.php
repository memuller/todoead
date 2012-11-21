<?php
global $table_prefix,$wpdb;
define('SUBSCRIBER_TABLE_NAME',$table_prefix . 'subscribes');

$subscriber_table = SUBSCRIBER_TABLE_NAME;
$message = '';
//Form Submitted
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['seller_category'])){
			
			$sql = "CREATE TABLE IF NOT EXISTS `$subscriber_table` (
					  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
					  `email` varchar(130) DEFAULT NULL,
					  `city_id` text NOT NULL,
					  PRIMARY KEY (`id`),
					  UNIQUE KEY `unq_e` (`email`)
					)"; 
			$wpdb->query($sql);
			
			//ddbwp_pr($_POST);
			$sql = "SELECT COUNT(*) FROM $subscriber_table where email='".$_REQUEST['data']['Subscribe']['email']."'";
			$emaillookup = $wpdb->get_var($sql);
			
			
				
			if(!$emaillookup){
				$wpdb->insert($subscriber_table, 
				
				array( 
					'email' => $_REQUEST['data']['Subscribe']['email'],
					'city_id' => $_REQUEST['seller_category'],					
				  )
				);
				
				$message = __('Thanks for subscribing.');
			}else{
				$message = __('<span style="color:red">You had already subscribed.</span>');	
			}
}

			$args = array(
                             //'show_option_all' => "Show All Categories",
                             'taxonomy' => CUSTOM_CATEGORY_TYPE1,
                             'name'     => CUSTOM_CATEGORY_TYPE1
                         );

		ob_start(); wp_dropdown_categories($args); $dropdown = ob_get_clean();
		
		$email = isset($_POST['data']['Subscribe']['email'])?$_POST['data']['Subscribe']['email']:'';
		$output ='
<style>
.enter-address-c{margin-top:0}
#content, #content input, #content textarea{
	line-height: 14px;
}
#deals_content .hint {
  width:334px;
}
.mail {
  float:left;
  width:420px;
}
</style>		
		<div id="deals_content">
  <div class="box">
    <div class="box-top">&nbsp;</div>
    <div class="box-content welcome">     
      <div class="sect">
        <div class="lead">
		';
		 $output .= empty($message)?'':'<p align="center" style="color:#060">'.$message.'</p>';
		 $output .='
          <h4>Enter your email address to receive daily deals in your inbox! </h4>
        </div>
        <div class="enter-address" style="height: 140px;">
          <p>Don\'t miss amazing savings on the best things to eat, see and do!</p>
          <div class="enter-address-c">
            <form id="enter-address-form" class="validator" action="'.get_permalink().'" method="post">
              <div class="mail">
                <label>Enter your e-mail address: </label>
                <input id="signup-username" class="f-input f-email" name="data[Subscribe][email]" size="30" value="'.$email.'" type="text">
                <span class="hint">Your name and e-mail will be used for internal purposes only.</span></div>
              <div style="float: left;">
                <label>Select your city:&nbsp;</label>'. $dropdown.'
                
              </div>
              <div class="city" style="clear: both;">
                <input id="enter-address-commit" class="formbutton" style="margin-left: 0px;" value="Subscribe" type="submit">
              </div>
            </form>
          </div>
        </div>
        <div class="intro">
          <p></p>
        </div>
      </div>
    </div>
    <div class="box-content welcome signinlink" style=" padding-right:10px;font-size: 18px;" align="right"><a href="'.wp_login_url( get_permalink() ).'">LOGIN</a>&nbsp;&nbsp;&nbsp;&nbsp;'.wp_register('', '',false).'</div>
    <div class="box-bottom">&nbsp;</div>
  </div>
</div>

';
		$content = str_replace($email_identifier,$output,$content);	
?>