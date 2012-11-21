<?php
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	
$dealid = $_REQUEST['delete_id'];
global $wpdb;
do_action($dealid);
wp_delete_post($dealid);
echo "<div class='submitedsuccess'>".DEAL_DELETED."</div>";

?>