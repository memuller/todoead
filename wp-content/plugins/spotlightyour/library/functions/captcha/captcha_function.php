<?php
function pt_get_captch()
{
	global $captchaimagepath;
	$captchaimagepath = DDB_PUGIN_URL.'/library/functions/captcha/';
?>
<h4><?php echo CAPTCHA_TITLE_TEXT; ?></h4>
<div class="form_row clearfix">
<label><?php _e(CAPTCHA,'ddb_wp'); ?> <span class="indicates">*</span></label>
<input type="text" name="captcha"  class="textfield textfield_m" /> 
<img src="<?php DDB_PUGIN_URL;?>/library/functions/captcha/captcha.php" alt="captcha image" class="captcha_img" />
<?php if($_REQUEST['emsg']=='captch'){echo '<span class="message_error2" id="category_span">'.__('Please enter valid text as you shown in captcha.','ddb_wp').'</span>';}?>
<small><?php _e('Enter the text as you see in the image.','ddb_wp');?></small>
</div>
<?php
}
function pt_check_captch_cond()
{
	if($_SESSION["captcha"]==$_POST["captcha"])
	{
		return true;
	}
	else
	{
		return false;
	}	
}
?>