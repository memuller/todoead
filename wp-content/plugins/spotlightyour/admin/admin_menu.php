<?php
/////////////////////////////////////////
// ************* Theme Options Page *********** //
$admin_menu_access_level = apply_filters('DDBWP_admin_menu_access_level_filter',8);
define('DDBWP_ACCESS_USER',$admin_menu_access_level);
add_action('admin_menu', 'DDBWP_admin_menu'); //Add new menu block to admin side

add_action('DDBWP_admin_menu', 'DDBWP_add_admin_menu');
function DDBWP_admin_menu()
{
	do_action('DDBWP_admin_menu');	
}
function DDBWP_add_admin_menu(){
	$menu_title = apply_filters('DDBWP_admin_menu_title_filter',__('Theme Settings','ddb_wp'));
	if(function_exists(add_object_page))
    {
       add_object_page("Admin Menu",  $menu_title, DDBWP_ACCESS_USER, 'ddb_wp_wp_admin_menu', 'design'/*, DDB_PUGIN_URL.'images/favicon.ico'*/); // title of new sidebar
    }
    else
    {
       add_menu_page("Admin Menu",  $menu_title, DDBWP_ACCESS_USER, 'ddb_wp_wp_admin_menu', 'design'/*, DDB_PUGIN_URL.'images/favicon.ico'*/); // title of new sidebar
    }	
}
?>