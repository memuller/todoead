<?php 
//if (!session_id()){ session_start();}ob_start();
if (!class_exists('General')) {
	class General {
		// Class initialization
		function General() {
		}
		
		function get_payment_method($method)
		{
			global $wpdb;
			$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_$method'";
			$paymentinfo = $wpdb->get_results($paymentsql);
			if($paymentinfo)
			{
				foreach($paymentinfo as $paymentinfoObj)
				{
					$paymentInfo = unserialize($paymentinfoObj->option_value);
					return __('Pay with '.$paymentInfo['name']);
				}
			}
		}
		
		function get_product_imagepath()
		{
			return get_option('imagepath');
		}
		
		function get_product_tax()
		{
			return $this->get_product_tax_cal();
		}
		
		function getLoginUserInfo()
		{
			$logininfoarr = explode('|',$_COOKIE[LOGGED_IN_COOKIE]);
			if($logininfoarr)
			{
				global $wpdb;
				$userInfoArray = array();
				$usersql = "select * from $wpdb->users where user_login = '".$logininfoarr[0]."'";
				$userinfo = $wpdb->get_results($usersql);
				foreach($userinfo as $userinfoObj)
				{
					$userInfoArray['ID'] = 	$userinfoObj->ID;
					$userInfoArray['display_name'] = 	$userinfoObj->display_name;
					$userInfoArray['user_nicename'] = 	$userinfoObj->user_login;
					$userInfoArray['user_email'] = 	$userinfoObj->user_email;
					$userInfoArray['user_id'] = 	$logininfoarr[0];
				}
				return $userInfoArray;
			}else
			{
				return false;
			}
		}
		
		
		function sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
		{
			if($fromEmail && $toEmail)
			{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				
				// Additional headers
				$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
				$headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
				// Mail it
				//@mail($toEmail, $subject, $message, $headers);
				/*echo "From : $toEmailName - $fromEmail <br>";
				echo "From : $toEmailName - $toEmail <br>";
				echo $subject.'<br>';
				echo $message.'<br>';
				echo $headers;exit;*/
				if(wp_mail( $toEmail, $subject, $message, $headers ))
				{
					
				}else
				{
					mail( $toEmail, $subject, $message, $headers );
				}
			}
		}
		
		
		function get_post_array($postid,$prdcount=5)
		{
			$prdcount++;
			$related_prd = 1;
			$postCatArr = wp_get_post_categories($postid);
			$postCatArr = implode(',',$postCatArr);
			$post_array = array();
			if($postCatArr)
			{
				$postCatStr = $postCatArr;
			}
			$category_posts=get_posts("numberposts=$prdcount&category=".$postCatStr);
			foreach($category_posts as $post) 
			{
				if($post->ID !=  $postid)
				{
					$post_array[$post->ID] = $post;
					$related_prd++;
				}
				if($related_prd==$prdcount)
				break;
			}
			return $post_array;
		}
		
		function get_digital_productpath()
		{
			return get_option('digitalproductpath');
		}
		
		function is_show_term_conditions()
		{
			return get_option('is_show_termcondition');
		}
		function get_term_conditions_statement()
		{
			return get_option('termcondition');
		}
		function get_loginpage_top_statement()
		{
			global $General;
			if(get_option('loginpagecontent'))
			{
				$topcontent = get_option('loginpagecontent');
				$store_name = get_option('blogname');
				$search_array = array('[#$store_name#]');
				$replace_array = array($store_name);
				$instruction = str_replace($search_array,$replace_array,$topcontent);
				?>
				<p class="login_instruction"><?php 	echo $instruction;	?> </p>
				<?php
			}else
			{
				_e(LOGIN_PAGE_TOP_MSG);
			}
		}
		
		function get_userinfo_mandatory_fields()
		{
			$return_array = array();
			if(!$this->is_storetype_digital())
			{
			$return_array['last_name'] = get_option('last_name');
			$return_array['bill_address1'] = get_option('bill_address1');
			$return_array['bill_address2'] = get_option('bill_address2');
			$return_array['bill_city'] = get_option('bill_city');
			$return_array['bill_state'] = get_option('bill_state');
			$return_array['bill_country'] = get_option('bill_country');
			$return_array['bill_zip'] = get_option('bill_zip');
			$return_array['bill_phone'] = get_option('bill_phone');
			}
			return $return_array;
		}
		
		function get_attribute_str($attribute_array)
		{
			for($i=0;$i<count($attribute_array);$i++)
			{
				if($attribute_array[$i])
				{
					$attribute_array[$i] = trim(preg_replace('/[(]([+-]+)(.*)[)]/','',$attribute_array[$i]));
				}
			}
			if($attribute_array && is_array($attribute_array))
			{
				return $aDDB_str = ','.implode(',',$attribute_array).',';	
			}else
			{
				return $aDDB_str = '';
			}
			
		}
		function all_product_listing_format()
		{
			 if(get_option('ddbwpthemes_prd_listing_format')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		function home_product_listing_format()
		{
			 if(get_option('ddbwpthemes_prd_listing_format_home')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		function archive_listing_format()
		{
			  if(get_option('ddbwpthemes_prd_listing_format_cat')=='grid')
			 {
				$showgrid = "thumb_view"; 
			 }else
			 {
				 $showgrid = "";
			 }
			 return $showgrid;
		}
		
		
		function is_allow_user_reglogin()
		{
			if(get_option('is_user_reg_allow'))
			{
				return true;
			}else
			{
				return false;
			}
		}
		function is_send_forgot_pw_email()
		{
			if(get_option('send_email_forgotpw') || get_option('send_email_forgotpw')=='')
			{
				return true;
			}else
			{
				return false;
			}
		}
		
		
		function show_home_link_header_nav()
		{
		?>
		 <li class="hometab <?php if ( is_home()&& $_GET['dwtype']=='') { ?>current_page_item <?php } ?>"><a href="<?php echo get_option('home'); ?>/"><?php _e(HOME_TEXT);?></a></li>
		<?php
		}
		function show_pages_header_nav()
		{
			if(get_option('ddbwpthemes_pageheader_display')=='Show' || get_option('ddbwpthemes_pageheader_display')=='')
			{
				wp_list_pages('title_li=&depth=0&exclude=' . get_inc_pages("pag_exclude_") .'&sort_column=menu_order');
			}
		}
		
		function get_blog_sub_cats_str($type='array')
		{
			$catid = get_inc_categories("cat_exclude_");
			$catid_arr = explode(',',$catid);
			$blogcatids = '';
			$subcatids_arr = array();
			for($i=0;$i<count($catid_arr);$i++)
			{
				if($catid_arr[$i])
				{
					$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
				}
			}
			if($subcatids_arr && $type=='string')
			{
				$blogcatids = implode(',',$subcatids_arr);
				return $blogcatids;	
			}else
			{
				return $subcatids_arr;
			}			
		}
		
		function show_blog_link_header_nav()
		{
			global $General;
			$blogcatids = $General->get_blog_sub_cats_str('string');
			if($blogcatids && $General->is_show_blogpage())
			{
				$categoyli = wp_list_categories ('title_li=&use_desc_for_title=0&depth=0&include=' . $blogcatids. '&sort_column=menu_order&echo=0'); 
				if(!strstr($categoyli,'No categories'))
				{
					echo $categoyli;	
				}
			}
			
		}
		function show_category_header_nav()
		{
			if(get_option('ddbwpthemes_catheader_display')=='Show')
			{
				$categories = get_option('ddbwpthemes_categories_id');
				if(is_array($categories))
				{
					$categories = implode(',',$categories);
				}
				$categoyli = wp_list_categories ('title_li=&use_desc_for_title=0&depth=0&include=' . $categories. '&sort_column=menu_order&echo=0'); 
				if(!strstr($categoyli,'No categories'))
				{
					echo $categoyli;	
				}
			}
			
		}
		
		function is_on_ssl_url()
		{
			if(get_option('is_on_ssl'))
			{
				return true;
			}else
			{
				return false;
			}
		}
		function allow_autologin_after_reg()
		{
			if(get_option('allow_autologin_after_reg') || get_option('allow_autologin_after_reg')=='')
			{
				return true;
			}else
			{
				return false;
			}
		}
		function get_ssl_normal_url($url)
		{
			if($this->is_on_ssl_url())
			{
				$url = str_replace('http://','https://',$url);
			}
			return $url;
		}
		function get_url_login($url)
		{
			if(get_option('is_on_ssl_login'))
			{
				return $url = str_replace('http://','https://',$url);
			}else
			{
				return $url;
			}
			return $url;
		}
		
		function view_store_link_home()
		{
		?>
        <a href="<?php echo site_url("/?dwtype=store");?>" class="highlight_button fr" ><?php _e(VIEW_STORE_TEXT);?></a>
        <?php	
		}
		
		function show_term_and_condition()
		{
			global $General;
			if($General->is_show_term_conditions())
			{
			?>
			<div class="terms_condition clearfix">
			<input type="checkbox" name="termsandconditions" id="termsandconditions" class="checkin2" />&nbsp;
			<?php
			if($General->get_term_conditions_statement()!='')
			{
			echo $General->get_term_conditions_statement();
			}else
			{
			_e(CHECKOUT_TERMS_CONDITIONS_MSG);
			}
			?>
			</div>
			<?php
			}
		}
		
	
	}
	// Start this plugin once all other plugins are fully loaded
}
if(!$General)
{
	$General = new General();
}
?>