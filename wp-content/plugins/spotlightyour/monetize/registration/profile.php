<?php
if($_POST)
{
	if (!session_id()){ session_start();}
	ob_start();
	if(!$current_user->data->ID)
	{
		wp_redirect(get_settings('home').'/index.php?page=login');
		exit;
	}

	$user_id = $current_user->data->ID;
	$user_email = $_POST['user_email'];
	$userName = $_POST['user_fname'];
	$pwd = $_POST['pwd'];
	$cpwd = $_POST['cpwd'];
	if(isset($_REQUEST['Update']))
	{
		if($user_email)
		{
			$check_users=$wpdb->get_var("select ID from $wpdb->users where user_email like \"$user_email\" where ID!=\"$user_id\"");
			if($check_users)
			{
				wp_redirect(site_url().'/?dwtype=profile&emsg=wemail');exit;	
			}
			
		}else
		{
				wp_redirect(site_url().'/?dwtype=profile&emsg=empty_email');exit;
		}
		if($pwd!=$cpwd)
		{
			wp_redirect(site_url().'/?dwtype=profile&emsg=pw_nomatch');exit;
		}
	}
	if($userName)
	{
		if($pwd)
		{
			$pwd = md5($pwd);
			$subsql = " , user_pass=\"$pwd\"";	
		}
		$updateUsersql = "update $wpdb->users set user_email=\"$user_email\", display_name=\"$userName\" $subsql  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
		
		global $upload_folder_path;
		global $form_fields_usermeta;
		foreach($form_fields_usermeta as $fkey=>$fval)
		{
			$fldkey = "$fkey";
			$$fldkey = $_POST["$fkey"];
			if($fval['type']=='upload')
			{
				
				if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
					$dirinfo = wp_upload_dir();
					$path = $dirinfo['path'];
					$url = $dirinfo['url'];
					$destination_path = $path."/";
					$destination_url = $url."/";
					
					$src = $_FILES[$fkey]['tmp_name'];
					$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
					$target_file = $destination_path.$file_ame;
					if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
					{
						$image_path = $destination_url.$file_ame;
					}else
					{
						$image_path = '';	
					}
					
					$_POST[$fkey] = $image_path;
					$fldkey = $image_path;
					
				}
				else{
					$_POST[$fkey]=$_POST['prev_upload'];
				}
				
			
			}
			
			update_usermeta($user_id, $fkey, $$fldkey); // User Custom Metadata Here
		}
		
		
		wp_redirect(site_url().'/?dwtype=profile&msg=success');exit;
	}
	
	if(isset($_REQUEST['update_profile']))
	{
		$destination_path1 = ABSPATH.'/wp-content/uploads/';
		$uploadpath = wp_upload_dir(); 
		$tmpfolder = $uploadpath['baseurl'].'/tmp/';
		$imgstr = '';
	
		$user_id = $current_user->data->ID;
		$user_facebook = $_REQUEST['user_facebook'];
		$user_twitter = $_REQUEST['user_twitter'];
		$user_website = $_REQUEST['user_website'];
		$user_about = $_REQUEST['user_about'];
		$user_photo = $_FILES['user_photo']['name'];
		
		$user_info = array(
							"user_facebook"		=> $user_facebook,
							"user_twitter"		=> $user_twitter,
							"user_website"		=> $user_website,
							"user_about"	=> $user_about,
							"user_photo"	=> $user_photo,
							
							);
	
		update_usermeta($user_id, 'user_facebook', $user_facebook);
		update_usermeta($user_id, 'user_twitter',$user_twitter);	
		update_usermeta($user_id, 'user_website', $user_website);	
		update_usermeta($user_id, 'user_about', $user_about);	
			// User Address Information Here
		if($user_photo != "" )
		{
			$user_photo = $_FILES["user_photo"]["name"];
			$exts1 = " ";
			function findexts_photo($user_photo) 
			{ 
				return substr(strrchr($user_photo,'.'),1);
			}
			//function for finding an extension for an image ends here
			if(isset($filename) && $filename!='')
			{
				$exts1 = findexts_photo($user_photo);
				$_SESSION['user_photo'] = time().rand().$user_photo;
			}
			
			if(isset($_FILES["user_photo"]["name"]) && !file_exists($destination_path1.$_SESSION['user_photo']))
			{
				move_uploaded_file($_FILES["user_photo"]["tmp_name"],$destination_path1.$_SESSION['user_photo']);
				$destination_path1.$_SESSION['user_photo']; 
			}else{
				echo "There is some problem in uploading file";
			}
			$user_photo1 = $_SESSION['user_photo']; 
		}else{
		
			$user_photo1 = get_user_meta($current_user->data->ID,'user_photo',true); 
		}
		$user_photo1;
		
		update_usermeta($current_user->data->ID, 'user_photo', $user_photo1);
		$userName = $_POST['user_fname'].' '.$_POST['user_lname'];
		$updateUsersql = "update $wpdb->users set user_url=\"$user_website\"";
		$wpdb->query($updateUsersql);
		$_SESSION['session_message'] = INFO_UPDATED_SUCCESS_MSG;
		echo "<script>location.href='?dwtype=profile';</script>";
		
		
	}
}
?>


<?php wp_enqueue_script('jquerymin', DDB_MODULE_FOLDER_URL . 'registration/jquery-1.2.6.min.js');?>
<?php get_header(); ?>

<?php if ( get_option('ddbwpthemes_breadcrumbs' )) { 
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
 ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php echo HOME;?></a> <?php echo $sep; ?> <?php echo EDIT_PROFILE_TITLE; ?> </div>
    </div>
<?php } ?>
<script>var rootfolderpath = '<?php echo DDB_PUGIN_URL;?>/images/';</script>
<script type="text/javascript" src="<?php echo DDB_PUGIN_URL;?>/js/dhtmlgoodies_calendar.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php echo DDB_PUGIN_URL;?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,link,unlink,image",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<div  class="content content_full editprofile_page" >
<!--  CONTENT AREA START -->
  <div class="entry">
    <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
      <div class="post-meta">
        <?php //DDBWP_page_title_above(); //page title above action hook?>
        <?php echo DDBWP_page_title_filter(EDIT_PROFILE_TITLE); //page tilte filter?>
        <?php //DDBWP_page_title_below(); //page title below action hook?>
      </div>
      <div >
        <div class="post-content">
          <div id="sign_up">
            <?php
if ( $_REQUEST['msg']=='success')
{
	echo "<p class=\"success_msg\"> ".EDIT_PROFILE_SUCCESS_MSG." </p>";
}else
if ( $_REQUEST['emsg']=='empty_email')
{
	echo "<p class=\"error_msg\"> ".EMPTY_EMAIL_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='wemail')
{
	echo "<p class=\"error_msg\"> ".ALREADY_EXIST_MSG." </p>";
}elseif ( $_REQUEST['emsg']=='pw_nomatch')
{
	echo "<p class=\"error_msg\"> ".PW_NO_MATCH_MSG." </p>";
}
?>
<div class="registration_form_box">
  <?php 
  if($_SESSION['session_message'])
	{
		echo '<p>'.$_SESSION['session_message'].'</p>';
		$_SESSION['session_message'] = '';
	}
   ?>
 
  <form name="userform" id="personal_info" action="<?php echo site_url().'/?dwtype=profile'; ?>" method="post" enctype="multipart/form-data" >    
      <h5><?php _e(PERSONAL_INFO_TEXT);?></h5>
       <div class="form_row clearfix">
        <label><?php _e(FACEBOOK_TEXT) ?> <span class="indicates">*</span></label>
        <input type="text" name="user_facebook" id="user_facebook" class="textfield" value="<?php echo get_user_meta($current_user->data->ID,'user_facebook',true); ?>" size="25" tabindex="20" />
        <span class="message_error2" id="user_fname_span"></span>
      </div>
        <div class="form_row clearfix">
        <label><?php _e(TWITTER_TEXT) ?></label>
        <input type="text" name="user_twitter" id="user_twitter" class="textfield" value="<?php echo get_user_meta($current_user->data->ID,'user_twitter',true); ?>" size="25" tabindex="20" />
      </div>
       <div class="form_row clearfix">
        <label><?php _e(YR_WEBSITE_TEXT) ?></label>
        <input type="text" name="user_website" id="user_website" class="textfield" value="<?php echo get_user_meta($current_user->data->ID,'user_website',true); ?>" size="25" tabindex="20" />
      </div>
        <div class="form_row clearfix">
        <label><?php _e(ABOUT_TEXT) ?></label>
		</div>
		<div class="form_row clearfix">
       	<textarea name="user_about" id="user_about" class="textfield" cols="30" rows="7">
		<?php echo get_user_meta($current_user->data->ID,'user_about',true); ?></textarea>
		<small><?php _e(ABOUT_U_TEXT) ?></small><span id="deal_descInfo" class="error"></span>
		</div>
      
		
		<div class="form_row clearfix">
		<label><?php echo "Upload your Photo :";?></label>
		<?php if(get_user_meta($current_user->data->ID,'user_photo',true) != "") { 
		$destination_path1 =  ABSPATH."/wp-content/uploads/"; ?>
		   <img src="<?php echo DDBWP_thumbimage_filter($destination_path1.get_user_meta($current_user->data->ID,'user_photo',true),'&amp;w=165&amp;h=180&amp;zc=1&amp;q=80'); ?>" alt="<?php echo $current_user->data->display_name; ?>" title="<?php echo $current_user->data->display_name; ?>"  />
                    <?php }else{ ?>
           <img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=258&amp;h=150&amp;zc=1&amp;q=80');?>" alt="" />
		<?php } ?>
		<input type="file" name="user_photo" id="user_photo" class="textfield"/>
		</div>
    
   <input type="submit" name="update_profile" value="<?php _e(EDIT_PROFILE_UPDATE_BUTTON);?>" class="b_registernow" onclick="return chk_edit_profile();" />
   
   <input type="button" name="Cancel" value="Cancel" class="button_cancel" onclick="window.location.href='<?php echo site_url()."?dwtype=deals"; ?>'"/>
   
</form>

 
<form name="userform" id="userform" action="<?php echo site_url().'/?dwtype=profile'; ?>" method="post" enctype="multipart/form-data" >  
	
     <h5><?php _e(EDIT_PROFILE_PAGE_TITLE);?></h5>

                <?php
if($_POST)
{
	$user_email = $_POST['user_email'];	
	$user_fname = $_POST['user_fname'];	
}else
{
	$user_email = $current_user->data->user_email;	
	$user_fname = $current_user->data->display_name;
}
?>
<?php do_action('DDBWP_profile_form_start');?>

<?php
global $form_fields_usermeta;
$validation_info = array();
foreach($form_fields_usermeta as $key=>$val)
{
	if($val['on_profile']){
	$str = ''; $fval = '';
	$field_val = $key.'_val';
	if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
	
	if($val['is_require'])
	{
		$validation_info[] = array(
								   'name'	=> $key,
								   'espan'	=> $key.'_error',
								   'type'	=> $val['type'],
								   'text'	=> $val['label'],
								   );
	}
	if($key)
	{
		$fval = $current_user->data->$key;
	}
	if($val['type']=='text')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';
		}
	}elseif($val['type']=='hidden')
	{
		$str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='textarea')
	{
		$str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='texteditor')
	{
		
		$str = $val['tag_before'].'<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>'.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='file')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='include')
	{
		$str = @include_once($val['default']);
	}else
	if($val['type']=='head')
	{
		$str = '';
	}else
	if($val['type']=='date')
	{
		$str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';	
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catselect')
	{
		$term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key => $cat) 
		{
		
			$seled='';
			if($term->name==$cat->name){ $seled='selected="selected"';}
			$str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catdropdown')
	{
		$cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
		$cat_args['show_option_none'] = __('Select City','ddb_wp');
		$str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='select')
	{
		$str = '<select name="'.$key.'" '.$val['extra'].'>';
		$option_values_arr = explode(',', $val['options']);
		for($i=0;$i<count($option_values_arr);$i++)
		{
			$seled='';
			
			if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
			$str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
		}
		$str .= '</select>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catcheckbox')
	{
		$fval_arr = explode(',',$fval);
		$str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='catradio')
	{
		$args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
		$all_categories = get_categories($args);
		foreach($all_categories as $key1 => $cat) 
		{
			
			
				$seled='';
				if($fval==$cat->term_id){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
			
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='checkbox')
	{
		if($fval){ $seled='checked="checked"';}
		$str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='upload')
	{
		$str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
			if($fval!=''){
				$str .='<img src="'.DDBWP_thumbimage_filter($fval,'&amp;w=121&amp;h=115&amp;zc=1&amp;q=80').'" alt="" />
				<br />
				<input type="hidden" name="prev_upload" value="'.$fval.'" />
				';	
			}
		if($val['is_require'])
		{
			$str .='<span id="'.$key.'_error"></span>';	
		}
	}
	else
	if($val['type']=='radio')
	{
		$options = $val['options'];
		if($options)
		{
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$seled='';
				if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}else
	if($val['type']=='multicheckbox')
	{
		$options = $val['options'];
		if($options)
		{  $chkcounter = 0;
			
			$option_values_arr = explode(',',$options);
			for($i=0;$i<count($option_values_arr);$i++)
			{
				$chkcounter++;
				$seled='';
				if(in_array($option_values_arr[$i],$fval)){ $seled='checked="checked"';}
				$str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
			}
			if($val['is_require'])
			{
				$str .= '<span id="'.$key.'_error"></span>';	
			}
		}
	}
	else
	if($val['type']=='packageradio')
	{
		$options = $val['options'];
		foreach($options as $okey=>$oval)
		{
			$seled='';
			if($fval==$okey){$seled='checked="checked"';}
			$str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
		}
		if($val['is_require'])
		{
			$str .= '<span id="'.$key.'_error"></span>';	
		}
	}else
	if($val['type']=='geo_map')
	{
		do_action('DDBWP_submit_form_googlemap');	
	}else
	if($val['type']=='image_uploader')
	{
		do_action('DDBWP_submit_form_image_uploader');	
	}
	if($val['is_require'])
	{
		$label = '<label>'.$val['label'].' <span>*</span> </label>';
	}else
	{
		$label = '<label>'.$val['label'].'</label>';
	}
	echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
	}
}
?>
<?php do_action('DDBWP_profile_form_end');?>
  <div class="form_row clearfix">
    <label> <?php echo PASSWORD_TEXT; ?> </label>
    <input type="password" name="pwd" id="pwd" class="textfield" value="" size="25"  />
    <span id="pwdInfo"></span>
  </div>
  <div class="form_row clearfix">
    <label> <?php echo CONFIRM_PASSWORD_TEXT ?> </label>
    <input type="password" name="cpwd" id="cpwd" class="textfield" value="" size="25"  />
    <span id="cpwdInfo"></span> 
  </div>
  
  
    <input type="submit" name="update" value="<?php echo EDIT_PROFILE_UPDATE_BUTTON;?>" class="b_registernow" />
  
     <input type="button" name="Cancel" value="Cancel" class="button_cancel" onclick="window.location.href='<?php site_url()."?dwtype=deals"; ?>'"/>
  
  </form>
  

            </div>
          </div>
        </div>
        <!-- post content #end -->
      </div>
    </div>
  </div>
  </div>
<?php include_once(DDB_REGISTRATION_FOLDER_PATH . 'registration_validation.php');?>
<?php  // get_sidebar(); ?>
<?php get_footer(); ?>
