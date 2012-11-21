<?php
/* * * Theme setup ** */
define('DDB_ADMIN_FOLDER_NAME', 'admin');
define('DDB_ADMIN_FOLDER_PATH', DDB_PUGIN_PATH . '/' . DDB_ADMIN_FOLDER_NAME . '/'); //admin folder path

update_option('users_can_register','1');

$result = add_role('merchant', 'Merchant', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
	'level_1'=> true,
	'level_0'=> true,
    'delete_posts' => false, // Use false to explicitly deny
));


/* * ** Debug ** */

function ddbwp_pr($output, $die = true) {

    if (is_array($output) || is_object($output)) {
        echo "<pre>";
        print_r($output);
        echo "</pre>";
    }else
        echo "<hr><br>$output<br><hr>";
    if ($die)
        die('Debuging is enabled');
}

if (file_exists(DDB_ADMIN_FOLDER_PATH . 'constants.php')) {
    include_once(DDB_ADMIN_FOLDER_PATH . 'constants.php');  //ALL CONSTANTS FILE INTEGRATOR
}



if (file_exists(DDB_FUNCTIONS_FOLDER_PATH . 'custom_filters.php')) {
    include_once (DDB_FUNCTIONS_FOLDER_PATH . 'custom_filters.php'); // manage theme filters in the file
}

if (file_exists(DDB_FUNCTIONS_FOLDER_PATH . 'widgets.php')) {
    include_once (DDB_FUNCTIONS_FOLDER_PATH . 'widgets.php'); // theme widgets in the file
}

// Theme admin functions
include_once (DDB_FUNCTIONS_FOLDER_PATH . 'custom_functions.php');

include_once(DDB_ADMIN_FOLDER_PATH . 'admin_main.php');  //ALL ADMIN FILE INTEGRATOR
//die('I am here');

function temp_theme_settings_load() {
    if ($_GET['page'] == 'paymentoptions' || $_GET['page'] == 'notification' || $_GET['page'] == 'custom' || $_GET['page'] == 'custom_usermeta' || $_GET['page'] == 'report') {


// enqueue styles
        wp_enqueue_style('option-tree-style', DDB_THEME_OPTIONS_FOLDER_URL . 'css/option_tree_style.css', false, 1, 'screen');
// enqueue scripts
        add_thickbox();
        wp_enqueue_script('jquery-table-dnd', DDB_THEME_OPTIONS_FOLDER_URL . 'js/jquery.table.dnd.js', array('jquery'), 1);
        wp_enqueue_script('jquery-color-picker', DDB_THEME_OPTIONS_FOLDER_URL . 'js/jquery.color.picker.js', array('jquery'), 1);
        wp_enqueue_script('jquery-option-tree', DDB_THEME_OPTIONS_FOLDER_URL . 'js/jquery.option.tree.js', array('jquery', 'media-upload', 'thickbox', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-table-dnd', 'jquery-color-picker'), 1);

// remove GD star rating conflicts
        wp_deregister_style('gdsr-jquery-ui-core');
        wp_deregister_style('gdsr-jquery-ui-theme');
    }
}

add_action('admin_init', 'temp_theme_settings_load'); //adction to add js and css to wp-admin head section


if (file_exists(DDB_WIDGET_FOLDER_PATH . 'widgets_main.php')) {
    include_once (DDB_WIDGET_FOLDER_PATH . 'widgets_main.php'); // Theme admin WIDGET functions
}

if (file_exists(DDB_MODULES_FOLDER_PATH . 'modules_main.php')) {
    include_once (DDB_MODULES_FOLDER_PATH . 'modules_main.php'); // Theme moduels include file
}
if (file_exists(DDB_MODULES_FOLDER_PATH . 'registration/reg_main.php.php')) {
    include_once(DDB_MODULES_FOLDER_PATH . 'registration/reg_main.php.php');
}
// registration, login and edit profile
if (file_exists(DDB_MODULES_FOLDER_PATH . 'deal/deal_main.php')) {
    include_once(DDB_MODULES_FOLDER_PATH . 'deal/deal_main.php');
}


if (file_exists(DDB_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php')) {
    include_once (DDB_INCLUDES_FOLDER_PATH . 'auto_install/auto_install.php'); // sample data insert file
}
if (file_exists(DDB_FUNCTIONS_FOLDER_PATH . 'captcha/captcha_function.php')) {
    include_once (DDB_FUNCTIONS_FOLDER_PATH . 'captcha/captcha_function.php'); // manage theme filters in the file
}
if (file_exists(DDB_FUNCTIONS_FOLDER_PATH . 'manage_custom_fields/functions_custom_field.php')) {
    include_once (DDB_FUNCTIONS_FOLDER_PATH . 'manage_custom_fields/functions_custom_field.php'); // manage theme filters in the file
}
require("language.php");
require(DDB_FUNCTIONS_FOLDER_PATH . "general_functions.php");
$General = new General();
global $General;
add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

@ini_set('upload_max_size', '164M');
@ini_set('post_max_size', '164M');
@ini_set('max_execution_time', '300');

############### Setting Front Page ###############
if (!is_admin()) { 
    include_once('front_page.php');
}


///################  Adding Schedular  ##############
//register_activation_hook(__FILE__, 'ddwp_cron_activation');

add_action('ddbwp_hourly_event', 'DDBWP_GetPing');
 include(DDB_PUGIN_PATH.'/schedular.php');
function DDBWP_GetPing() {
  mailMeLog("Schedular is running at ".date("d M Y, h:i:s A"));
  if(get_option("ddbwpthemes_show_icoupon_deals")!='Yes'){
	return false;
	}
	
	$cron_status = get_option('ddbwpthemes_icoupon_status');		
	$next_executed = get_option('ddbwpthemes_icoupon_nextcron');	
	if(!empty($next_executed)){
		$timediff = time() - (int) $next_executed;
		if($timediff < 0){
			//echo "Cron is already already executed";
			return false;
		}
	}
	
	if($cron_status == "" || $cron_status == "0"){
			update_option('ddbwpthemes_icoupon_status',1);
			//update_option('ddbwpthemes_icoupon_status',1);	
	}else
		return false;
  
  if(get_option("ddbwpthemes_show_icoupon_deals")=='Yes'){
		//sleep(rand(5,25));
		clearImgCache();
		getICouponDeals();
	}
 
 /*$expire=time()+60*60*24;
 setcookie("icoupon", "spotlight", $expire);

 if(getenv("OS")=="Windows_NT") {
   @file_get_contents(DDB_PUGIN_URL.'schedular.php');  
 }
 else {
  	$exec = exec("curl ".DDB_PUGIN_URL.'schedular.php &> /dev/null &');    	
 } */
}


###########################


if (isset($_REQUEST['author'])) {
    include_once( ABSPATH . 'wp-load.php' );
    include_once( ABSPATH . 'wp-includes/pluggable.php' );
    echo $url = site_url() . "?dwtype=author&at=" . $_REQUEST['author'];
    wp_redirect($url);
    exit();
}

function mailMeLog($message){
		
}

function ddbwp_install() {
	
	wp_schedule_event(time(), 'hourly', 'ddbwp_hourly_event');
	
	DDBWP_GetPing() ;
	//mailMeLog('Plugin is activated');
    autoinstall_admin_header();	
    //Creating Email Subscription page	
    /*$subscription_page = get_page_by_title("E-mail Subscriptions");
    if (empty($subscription_page))
        $page_id = ddb_createDealsPage('E-mail Subscriptions', '[DDB-WP SubscribeDeals]');*/

    //Creating SignUp For Merchant Account
    $subscription_page = get_page_by_title("Merchant SignUp");
    if (empty($subscription_page)){
        $page_id = ddb_createDealsPage('Merchant SignUp', '[DDB-WP Merchant-SignUp]');		
	}

    //Creating User login Page		
     $Blog_page = get_page_by_title( "Blog" );		
      if(empty($Blog_page))
      $page_id = ddb_createDealsPage('Blog',''); 

    //Creating Today Deals 		
    $deals_page = get_page_by_title("Today's Deals");
    if (empty($deals_page))
        $page_id = ddb_createDealsPage('Today\'s Deals', '[DDB-WP TodayDeals]');
}

//Create Deals Page 
function ddb_createDealsPage($ptitle, $pcontent) {

    global $user_ID;

    $page['post_type'] = 'page';
    $page['post_content'] = $pcontent;
    $page['post_parent'] = 0;
    $page['post_author'] = $user_ID;
    $page['post_status'] = 'publish';
    $page['post_title'] = $ptitle;
    $page['comment_status'] = 'closed';
    $page = apply_filters('ddbwp_add_new_page', $page, 'teams');
    $pageid = wp_insert_post($page);
    return $pageid;
}

function DDBWP_get_author_posts_url($author_id) {
    return site_url() . "?dwtype=author&at=$author_id";
}

function DDB_checkLicence() {
    $licence = get_option('ddbwpthemes_paid_ver');
    if (empty($licence))
        return false;
}

function ddbwp_deactivate(){
	global $wpdb,$deal_db_table_name;	
		
		wp_clear_scheduled_hook('ddbwp_hourly_event');
		
		update_option('show_on_front',  'posts');
		update_option('page_on_front',  '0');
		$page = get_page_by_title( 'Merchant SignUp' );
		wp_delete_post( $page->ID, true );
		$page = get_page_by_title( "Today's Deals" );
		wp_delete_post( $page->ID, true );
		$option_table_name = $wpdb->prefix."options";
	    $sql = "Delete from $option_table_name where `option_name` LIKE 'ddbwpthemes_%'";
	$wpdb->query($sql);
	ddbwp_removingIcouponDeals();
}

function ddbwp_removingIcouponDeals(){
	global $wpdb;	
	$sql = "SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = 'icoupon_id'";			
	
	$postids=$wpdb->get_col($sql);
	if ($postids) 
	{				
		$wpdb->query("DELETE FROM $wpdb->postmeta WHERE `post_id` IN (".implode(',',$postids).")");	
		$sql = "DELETE FROM $wpdb->posts WHERE ID  IN (".implode(',',$postids).")"; 
		$wpdb->query($sql);				
	}	
}

?>