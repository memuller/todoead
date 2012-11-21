<?php 
if(!function_exists('update_option')){
		$file = dirname(__FILE__);
		$file = substr($file,0,stripos($file, "wp-content"));
		require($file . "/wp-load.php");
	}
if(isset($_REQUEST['licence'])){
		if(strlen($_REQUEST['licence'])>10)
			update_option("ddbwpthemes_paid_ver",$_REQUEST['licence']);	
		else
			update_option("ddbwpthemes_paid_ver",'');	
	 die('done');
	}
?>