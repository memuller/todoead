<?php
/*** Theme setup ***/
// This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'ddb_wp', DDB_PUGIN_PATH . '/languages' );

// This theme uses wp_nav_menu() in one location.
$nav_menu_arg = array();
$nav_menu_arg['primary'] = __( 'Top Header Navigation', 'ddb_wp' );
//$nav_menu_arg['secondary'] = __( 'Main Navigation', 'ddb_wp' );
if($nav_menu_arg){ register_nav_menus( $nav_menu_arg );}

global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}

if(!defined('DDB_IMAGE_URL'))
	define('DDB_IMAGE_URL',DDB_PUGIN_PATH.'/images/');

define('DDB_ADMIN_FOLDER_NAME','admin');
define('DDB_ADMIN_FOLDER_URL',DDB_PUGIN_PATH.'/'.DDB_ADMIN_FOLDER_NAME.'/'); //css folder url
define('DDB_THEME_OPTIONS_FOLDER_URL',DDB_PUGIN_URL.'/'.DDB_ADMIN_FOLDER_NAME.'/theme_options/'); //css folder url
define('DDB_WIDGETS_FOLDER_URL',DDB_PUGIN_URL.'/'.DDB_ADMIN_FOLDER_NAME.'/widgets/'); //WIDGET folder url
define('DDB_WIDGET_JS_FOLDER_URL',DDB_WIDGETS_FOLDER_URL.'widget_js/'); //widget javascript folder url
define('DDB_FUNCTIONS_FOLDER_URL',DDB_PUGIN_PATH.'/library/functions/'); //theme functions folder url
define('DDB_INCLUDES_FOLDER_URL',DDB_PUGIN_PATH.'/library/includes/'); //theme includes folder url
define('DDB_CSS_FOLDER_URL',DDB_PUGIN_PATH.'/library/css/'); //theme css folder url
define('DDB_MODULE_FOLDER_URL',DDB_PUGIN_PATH.'/modules/'); //theme css folder url


define('DDB_ADMIN_FOLDER_PATH',DDB_PUGIN_PATH.'/'.DDB_ADMIN_FOLDER_NAME.'/'); //admin folder path
if(file_exists(DDB_PUGIN_PATH . '/ecommerce/'))
	define('DDB_MODULES_FOLDER_PATH',DDB_PUGIN_PATH.'/dailydealnew/'); //addons folder path
else  if(file_exists(DDB_PUGIN_PATH . '/monetize/'))
	define('DDB_MODULES_FOLDER_PATH',DDB_PUGIN_PATH.'/monetize/'); //addons folder path
		
define('DDB_WIDGET_FOLDER_PATH',DDB_ADMIN_FOLDER_PATH.'widgets/'); //widget folder path
define('DDB_LIBRARY_FOLDER_PATH',DDB_PUGIN_PATH.'/library/'); //library folder path
define('DDB_FUNCTIONS_FOLDER_PATH',DDB_LIBRARY_FOLDER_PATH . 'functions/'); //functions folder path
define('DDB_JSCRIPT_FOLDER_PATH',DDB_LIBRARY_FOLDER_PATH . 'js/'); //javascript folder path
define('DDB_CSS_FOLDER_PATH',DDB_LIBRARY_FOLDER_PATH . 'css/'); //css folder path
define('DDB_INCLUDES_FOLDER_PATH',DDB_LIBRARY_FOLDER_PATH . 'includes/'); //includes folder path
define('DDB_ADMIN_TPL_PATH',DDB_ADMIN_FOLDER_PATH.'tpl/');  //structure folder path

//Current Version
define("DD_ICOUPON", false);
?>