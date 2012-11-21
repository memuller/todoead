<?php ob_start();
//Setting All the dealt settings

//style
DDBWP_setOpt("ddbwpthemes_alt_stylesheet",'green');

//Show icoupons
DDBWP_setOpt("ddbwpthemes_show_icoupon_deals",'Yes');

//Currency
DDBWP_setOpt("ddbwpthemes_default_currency",'USD-US Dollar');

//Tweet
DDBWP_setOpt("ddbwpthemes_tweet_button",'Yes');

//Facebook
DDBWP_setOpt("ddbwpthemes_facebook_button",'Yes');

//Content Display
DDBWP_setOpt("ddbwpthemes_postcontent_full",'Excerpt');

//Facebook Plugin Support
DDBWP_setOpt("ddbwpthemes_fb_opt",'Disable');

//Switch view for listing 
DDBWP_setOpt("ddbwpthemes_view_opt",'Grid View');

//Facebook Plugin Support
DDBWP_setOpt("ddbwpthemes_customcss",'Deactivate');

function DDBWP_setOpt($key, $def_value){
	if(get_option($key) == '') 
	{
		update_option($key, $def_value);
	}
}
if(1)
{
	
	
	function autoinstall_admin_header()
	{ 
		global $wpdb;
		if(get_option('ddbwpthemes_alt_stylesheet') == '') 
		{
			update_option("ddbwpthemes_alt_stylesheet",'green');
		}
		
		if(get_option('ddbwpthemes_show_icoupon_deals') == '') 
		{
			update_option("ddbwpthemes_show_icoupon_deals",'Yes');
		}
		
		update_option('pttthemes_send_mail','Enable');
		
			/*if($_REQUEST['dummy']=='del')
			{
				delete_dummy_data();	
				$dummy_deleted = '<p><b>All Dummy data has been removed from your database successfully!</b></p>';
			}*/
			if($_REQUEST['dummy_insert'])
			{
				$payment_url = file_get_contents('http://api.spotlightyour.com/get_product_url.php');
				if(empty($payment_url)){
					$payment_url = 'http://whmcssitelock.dealopia.com/cart.php?gid=2';
				}
				ob_clean();
				wp_redirect($payment_url);
			}
			if($_REQUEST['activated']=='true')
			{
					$theme_actived_success = '<p class="message">Theme activated successfully.</p>';	
			}
		
		if(1){
			$dummy_data_msg = '';
			if(get_option('ddbwpthemes_paid_ver') != '')
			{
				//$dummy_data_msg = '<p> <b>Sample data has been populated on your site. Wish to delete sample data?</b> <br />  <a class="button_delete" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p>';
			}else
			{
				$dummy_data_msg = 'Upgrade Your Account For Full Features! <a class="button_insert" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy_insert=1&dump=1">Please upgrade now</a>.';
			}
			//Check latest message
			$cver_url = 'http://api.wordpress.org/core/version-check/1.0/?version='.get_bloginfo('version');
			$cdata = file_get_contents($cver_url);
			if(trim($cdata) == 'latest'){
				$posstyle = '.update-nag-pos {margin: 0 15px 0 0;padding: 5px 0;}';	
				
			}else{
				$posstyle = '.update-nag-pos {margin: 0 15px 0 0;padding: 5px 0;}';	
			}
	
			define('THEME_ACTIVE_MESSAGE','
		<style>
		.highlight { width:60% !important; background:#FFFBCC !important; overflow:hidden; display:table; border:1px solid #E6DB55 !important; padding:15px 20px 0px 20px !important; -moz-border-radius:11px  !important;  -webkit-border-radius:11px  !important; margin:5px auto; } 
		.highlight p { color:#444 !important; font:15px Arial, Helvetica, sans-serif !important; text-align:center;  } 
		.highlight p.message { font-size:13px !important; }
		.wrap div.updated{margin:0 auto;}
		.highlight p a { color:#ff7e00; text-decoration:none !important; } 
		.highlight p a:hover { color:#000; }
		.highlight p a.button_insert 
			{ display:block; width:230px; margin:10px auto 0 auto;  background:#5aa145; padding:10px 15px; color:#fff; border:1px solid #4c9a35; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_insert { background:#347c1e; color:#fff; border:1px solid #4c9a35;   } 
		.highlight p a.button_delete 
			{ display:block; width:140px; margin:10px auto 0 auto; background:#dd4401; padding:10px 15px; color:#fff; border:1px solid #9e3000; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_delete { background:#c43e03; color:#fff; border:1px solid #9e3000;   } 
		#message0 { display:none !important;  }
		</style>
		
		<div class="updated highlight fade" align="center"> '.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>');
		$style = '<style>					
					'.$posstyle.'
					.update-nag-pos a{position:relative;z-index: 100000;}
					</style>';
			if(!empty($dummy_data_msg) && is_admin()){
				
				$file_name= end(explode('/',$_SERVER['SCRIPT_FILENAME']));
				if($file_name != 'plugins.php')			
					echo $style.'<div class="update-nag update-nag-pos">'.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>';
				//echo THEME_ACTIVE_MESSAGE;
			}
			
		}
	}
	
	if(is_admin())
		add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.

	function delete_dummy_data()
	{
		global $wpdb;
		delete_option('sidebars_widgets'); //delete widgets
		$productArray = array();
		$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1";
		$pids_info = $wpdb->get_results($pids_sql);
		foreach($pids_info as $pids_info_obj)
		{
			wp_delete_post($pids_info_obj->ID);
		}
	}
}
?>