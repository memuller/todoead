<?php
set_time_limit(0);
/////////admin menu settings start////////////////
add_action('DDBWP_admin_menu', 'framework_update_admin_menu');
function framework_update_admin_menu()
{
	add_submenu_page('ddb_wp_wp_admin_menu', __("Update Framework",'ddb_wp'), __("Update Framework",'ddb_wp'), DDBWP_ACCESS_USER, 'update_framework', 'update_framework');
}
/////////admin menu settings end////////////////
	
function update_framework(){
	
		if($_REQUEST['msg']=='success')
		{
			echo "<div id='framework-upgraded' class='updated fade'style='padding:5px; font-size:11px;' >New framework successfully downloaded, extracted and updated.</div>";
		}
        $method = get_filesystem_method();
       $to = DDB_FRAMEWORK_FOLDER_PATH;
        if(isset($_POST['password'])){
            $filesystem = WP_Filesystem($_POST);   
        }
        else {
           $filesystem = WP_Filesystem(); 
        };
        $url = admin_url('admin.php?page=update_framework');
        ?>
            <div class="wrap themes-page">
            <?php
            if($filesystem == false){
            request_filesystem_credentials ( $url );
            }  else {
             
            $curversion = DDBWP_FRAMWORK_CURRENT_VERSION;
            $liveversion = tmpl_current_framework_version();
            // Test if new version
           $is_update = DDBWP_is_updated( $curversion, $liveversion);
		  include 'tab_header.php'; 
		  ?>
		  <div class="block" id="option_update">
            
            <h2><?php _e('Update Framework','ddb_wp');?></h2>
            <span style="display:none"><?php echo $method; ?></span>
                <?php if( $is_update ) { ?>
                <form method="post"  name="framework_update" id="framework_update">
	            <input type="hidden" name="action" value="upgrade_framework" />
				<?php wp_nonce_field('update-options'); ?>
                <?php echo sprintf(__('<h3>A new version of ddb_wp Framework is available.</h3>
                <p>This updater will collect a file from the ddb_wp.com server. It will download and extract the files to your current theme&prime;s admin folder. </p>
                <p>We recommend backing up your theme files before updating. Only upgrade the ddb_wp Framework if necessary.</p>
                <p>If you are facing any problem in auto updating the framework, then please download the latest version of the theme from members area and then just overwrite the "<u>admin</u>" folder to the theme root.
				<p>&rArr; <strong>Your version:</strong> %s</p>
				
				<p>&rArr; <strong>Current Version:</strong> %s</p>','ddb_wp'),$curversion,$liveversion);?>
                <input type="submit" class="button" value="<?php _e('Update Framework','ddb_wp');?>" onclick="document.getElementById('framework_upgrade_process_span_id').style.display=''" />
                </form>
                <span id="framework_upgrade_process_span_id" style="display:none;"><h2 style="color:#900; "><?php _e('Updating, It will take few moments. Please wait....','ddb_wp');?></h2></span>
				<?php } else { ?>                
               <?php
               echo sprintf(__(' <h3>You already have the latest version of ddb_wp Framework</h3>
                <p>&rArr; <strong>Your version:</strong> %s ','ddb_wp'),$curversion);
				} ?>
            <?php } ?>
            <?php do_action('DDBWP_module_auto_update');?>
            </div>
			<?php include DDB_ADMIN_TPL_PATH.'footer.php';?>
            </div>
            <?php
};
function tmpl_current_framework_version($url = ''){
	
	if(!empty($url)){
		$framework_url = $url;
	} else {
    	$framework_url = DDBWP_FRAMWORK_CHANGE_LOG_PATH;
    }
	$temp_file_addr = download_url($framework_url);
	if(!is_wp_error($temp_file_addr) && $file_contents = file($temp_file_addr)) {
        foreach ($file_contents as $line_num => $line) {
			$current_line =  $line;
			if($line_num > 1){
				if (preg_match('/^[Version][^0-9]/', $line)) {
						$current_line = stristr($current_line,"Version");
						$current_line = preg_replace('~[^0-9,.]~','',$current_line);
						$output = $current_line;
						break;
				}
			}     
        }
        unlink($temp_file_addr);
        return $output;        
    } else {
        return __('Currently Unavailable','ddb_wp');
    }
}

function DDBWP_update_framework_process(){

if($_REQUEST['page'] == 'update_framework'){
	if($_REQUEST['action']){
		$src=DDBWP_FRAMWORK_ZIP_FOLDER_PATH;
		$dest=DDB_FRAMEWORK_FOLDER_PATH;
		if($_REQUEST['zip'])
		{
			$src=$_REQUEST['zip'];
		}
		if($_REQUEST['path'])
		{
			$dest=$_REQUEST['path'];
		}
		
	 	//Setup Filesystem 
		$method = get_filesystem_method();
		$filesystem = WP_Filesystem(); 
		if($filesystem == false && $_POST['upgrade'] != 'Proceed'){
			
			function DDBWP_framework_update_filesystem_warning() {
					$method = get_filesystem_method();
					echo "<div id='filesystem-warning' class='updated fade'><p>Failed: Filesystem preventing downloads. (". $method .")</p></div>";
				}
				add_action('admin_notices', 'DDBWP_framework_update_filesystem_warning');
				return;
		}

	$temp_file_addr = download_url($src);
	if ( is_wp_error($temp_file_addr) ) {
		$error = $temp_file_addr->get_error_code();
		if($error == 'http_no_url') {
		//The source file was not found or is invalid
			function DDBWP_update_framework_source_missing_warning() {
				echo "<div id='source-warning' class='updated fade'><p>Failed: Invalid URL Provided</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_source_missing_warning');
		} else {
			function DDBWP_update_framework_other_upload_warning() {
				echo "<div id='source-warning' class='updated fade'><p>Failed: Upload - $error</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_other_upload_warning');
		}
		return;
	  }
	  
	//Unzipp it
	global $wp_filesystem;
	$to = $dest;
	
	//$dounzip = unzip_file($temp_file_addr, $to);
	if(unzip_file($temp_file_addr, $to)==1)
	{
		
	}else
	{
	$zip = new ZipArchive;
	if ($zip->open($temp_file_addr) === TRUE) {
		@$zip->extractTo($to);
		@$zip->close();
	} else {
		$is_fail_flag = 1;
		$zip = zip_open($temp_file_addr);
		if ($zip) {
		  while ($zip_entry = zip_read($zip)) {
			$fp = fopen($to.zip_entry_name($zip_entry), "w");
			if (zip_entry_open($zip, $zip_entry, "r")) {
			  $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
			  fwrite($fp,"$buf");
			  zip_entry_close($zip_entry);
			  fclose($fp);
			  $is_fail_flag = 0;
			}
		  }
		  zip_close($zip);
		}
		if($is_fail_flag)
		{
			function DDBWP_update_framework_fail_warning() {
				echo "<div id='source-warning' class='updated fade'><p>Failed: Update - Framework fail because of some reason. You may like manual update via download latest framework and overwrite to 'admin' folder at theme root.</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_fail_warning');
		}
	}
	unlink($temp_file_addr); // Delete Temp File
	
	if ( is_wp_error($dounzip) ) {
		
		$error = $dounzip->get_error_code();
		$data = $dounzip->get_error_data($error);
		
		if($error == 'incompatible_archive') {
			//The source file was not found or is invalid
			function DDBWP_update_framework_no_archive_warning() {
				echo "<div id='tmpl-no-archive-warning' class='updated fade'><p>Failed: Incompatible archive</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_no_archive_warning');
		} 
		if($error == 'empty_archive') {
			function DDBWP_update_framework_empty_archive_warning() {
				echo "<div id='tmpl-empty-archive-warning' class='updated fade'><p>Failed: Empty Archive</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_empty_archive_warning');
		}
		if($error == 'mkdir_failed') {
			function DDBWP_update_framework_mkdir_warning() {
				echo "<div id='tmpl-mkdir-warning' class='updated fade'><p>Failed: mkdir Failure</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_mkdir_warning');
		}  
		if($error == 'copy_failed') {
			function DDBWP_update_framework_copy_fail_warning() {
				echo "<div id='tmpl-copy-fail-warning' class='updated fade'><p>Failed: Copy Failed</p></div>";
			}
			add_action('admin_notices', 'DDBWP_update_framework_copy_fail_warning');
		}
			
		return;

	} 
	}
	echo '<script>window.location.href="'.admin_url('admin.php?page=update_framework&msg=success').'";</script>';
	exit;
} //End user input save part of the update
}
}
add_action('admin_head','DDBWP_update_framework_process');


function DDBWP_is_updated($curversion='',$liveversion='')
{
	// Check if new version
	$is_update = false;
	$loc = explode('.',$curversion);				
	$rem = explode('.',$liveversion);	                
	if( $loc[0] < $rem[0] ) 
	{
		return $is_update = true;
	}
	if ( $loc[1] < $rem[1] )
	{
		return $is_update = true;
	}
	if( $loc[2] < $rem[2] )
	{
		return $is_update = true;
	}
	if( $loc[3] < $rem[3] )
	{
		return $is_update = true;	
	}
	return false;
}
?>