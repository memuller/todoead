<?php
/*
  Plugin Name: Spotlight
  Plugin URI: http://spotlightyour.com
  Description: Display Deals at your own site and also load icoupon affliate deals as well
  Version: 1.0
  Author: HC Consulting Group
  Author URI: http://www.hcdesk.com/
 */
########## 	Definfing The Costants  ############
ini_set("display_errors","On"); 
if (!defined("DDB_PUGIN_PATH")) {
    $path = plugin_dir_path(__FILE__);
    define("DDB_PUGIN_PATH", substr($path, 0, strlen($path) - 1));
}

if (strstr(DDB_PUGIN_PATH, '/'))
    $folder_name = end(explode('/', DDB_PUGIN_PATH));

if (strstr(DDB_PUGIN_PATH, '\\'))
    $folder_name = end(explode('\\', DDB_PUGIN_PATH));

if (!defined("DDB_PUGIN_URL"))
    define("DDB_PUGIN_URL", plugins_url() . '/' . $folder_name . '/');

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'ddbwp_install');
/* Runs when plugin is de-activated */
register_deactivation_hook( __FILE__ , 'ddbwp_deactivate' );

add_action('activated_plugin','save_error');
function save_error(){
    update_option('plugin_error',  ob_get_contents());
}

require_once(dirname(__FILE__) . '/ddbwp.php');
?>