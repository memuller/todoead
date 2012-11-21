<?php
define('DDB_CUSTOM_USERMETA_FOLDER_PATH',DDB_MODULES_FOLDER_PATH.'registration/custom_usermeta/');

global $wpdb,$table_prefix;
$custom_usermeta_db_table_name = $table_prefix . "ddb_wp_custom_usermeta";
if($wpdb->get_var("SHOW TABLES LIKE \"$custom_usermeta_db_table_name\"") != $custom_usermeta_db_table_name)
{
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_usermeta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,date,radio,select,textarea,upload",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `is_delete` tinyint(4) NOT NULL DEFAULT "0",
	  `is_require` tinyint(4) NOT NULL DEFAULT "0",
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
}

/////////admin menu settings start////////////////
add_action('DDBWP_admin_menu', 'custom_usermeta_add_admin_menu');
function custom_usermeta_add_admin_menu()
{
	add_submenu_page('ddb_wp_wp_admin_menu', __("Manage custom user-info fields",'ddb_wp'), __("Custom user-info",'ddb_wp'), DDBWP_ACCESS_USER, 'custom_usermeta', 'manage_custom_usermeta');
	add_submenu_page('ddb_wp_wp_admin_menu', __("Manage Cron settings",'ddb_wp'), __("Cron Settings",'ddb_wp'), DDBWP_ACCESS_USER, 'cron_settings', 'manage_cron_settings');
}

function manage_cron_settings(){	
	 global $wpdb,$custom_usermeta_db_table_name;
	 apply_filters( 'ddb_wp_custom_fields', include_once(DDB_CUSTOM_USERMETA_FOLDER_PATH . 'admin_cron_settings_list.php') )	;
}

function manage_custom_usermeta()
{
	DDB_checkLicence();
	global $wpdb,$custom_usermeta_db_table_name;
	if($_REQUEST['act']=='addedit')
	{
		apply_filters( 'ddb_wp_custom_fields', include_once(DDB_CUSTOM_USERMETA_FOLDER_PATH . 'admin_custom_usermeta_edit.php') )	;
	}else
	{
		apply_filters( 'ddb_wp_custom_fields', include_once(DDB_CUSTOM_USERMETA_FOLDER_PATH . 'admin_custom_usermeta_list.php') )	;
	}
}
/////////admin menu settings end////////////////
include_once (DDB_CUSTOM_USERMETA_FOLDER_PATH . 'custom_usermeta_functions.php');
include_once(DDB_CUSTOM_USERMETA_FOLDER_PATH.'manage_custom_usermeta.php');
?>