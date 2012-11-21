<?php
/******************************************************************
=======  PLEASE DO NOT CHANGE BELOW CODE  =====
You can add in below code but don't remove original code.
This code to include registration, login and edit profile page.
This file is included in functions.php of theme root at very last php coding line.

You can call registration, login and edit profile page  by the link 
edit profile : http://mydomain.com/?dwtype=profile  => echo site_url().'/?dwtype=profile';
registration : http://mydomain.com/?dwtype=register => echo site_url().'/?dwtype=register';
login : http://mydomain.com/?dwtype=login => echo site_url().'/?dwtype=login';
logout : http://mydomain.com/?dwtype=login&action=logout => echo site_url().'/?dwtype=login&action=logout';
********************************************************************/

define('DDBWP_REGISTRATION_FOLDER',DDB_MODULES_FOLDER_PATH . "registration/");
define('DDBWP_REGISTRATION_URI',DDB_PUGIN_URL . "monetize/registration/");

include_once(DDBWP_REGISTRATION_FOLDER.'registration_language.php'); // language file
////////Conditions to retrive the page HTML from the url.
add_filter('DDBWP_add_template_page_filter','DDBWP_add_template_reg_page');
function DDBWP_add_template_reg_page($template)
{
	if($_REQUEST['dwtype']=='profile')
	{
		global $current_user;
		if(!$current_user->data->ID)
		{
			wp_redirect(get_option('siteurl').'/?dwtype=login');
			exit;
		}
		$template = DDBWP_REGISTRATION_FOLDER.'profile.php';
	}else
	if($_REQUEST['dwtype'] == 'register' || $_REQUEST['dwtype'] == 'login')
	{
		$template =  DDBWP_REGISTRATION_FOLDER . "registration.php";
	}
	return $template;
}

function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}
?>