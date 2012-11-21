<?php // enqueue styles
wp_enqueue_style( 'option-tree-style',DDB_THEME_OPTIONS_FOLDER_URL.'css/option_tree_style.css', false, 1, 'screen');	
?>
<div id="framework_wrap" class="wrap">
	
	<div id="header">
    <h1></h1>
   			<div class="button_bar" style="width:50%">
				
		</div>  
 	</div>
  
  <div id="content_wrap">   
    
     
      <div id="content">
      
<div class="block" id="option_display_custom_usermeta">
<h3>Setup a real cron function from your host&rsquo;s control panel</h3>
<p>If you are allowed to setup cron jobs, you would have to setup a cron as below:</p>
<p>wget <?php echo site_url()?>/wp-cron.php &gt; /dev/null 2&gt;&amp;1</p>
<hr />
<h2>Below are the steps to do this from a cPanel based host.</h2>
<h3>1. Access your account&rsquo;s cPanel</h3>
<p>Usually the link is http://yourwebsite.com/cpanel or http://yourwebsite.com:2082. Once your enter your user id and password and enter the control panel, scroll down to the &quot;Advanced section&quot;.</p>
<h3>2. Go to Cron Settings Page</h3>
<p>Click on the &quot;Cron Jobs&quot; icon in the advanced section.</p>
<div><img src="<?php echo DDB_PUGIN_URL?>/images/image_02.jpg"  border="0" /></div>
<h3>3. Setup a Cron Job</h3>
<div><img src="<?php echo DDB_PUGIN_URL?>/images/image_03.jpg" alt="WordPress Login Page" border="0" ></div>
<p>On the new page you would find an &quot;Add New Cron Job&quot; section like the one in the above image. From the Common Settings drop down field, select &quot;Every 5 minutes…&quot;. Once you select this, the rest of the fields will be automatically filled with the necessary information. </p>
<p>In the command field, add the below line. </p>
<p>wget <?php echo site_url()?>/wp-cron.php &gt; /dev/null 2&gt;&amp;1</p>
<p><strong><em>Remember to add the correct website address.</em></strong></p>
<p>Finally, click on the &quot;Add New Cron Job&quot; button.</p>
<p>From now on the server will make a request for the wp-cron.php file every 5 minutes. </p>
<p><strong>NOTE:</strong> <em>This runs well for general WordPress websites. For those using a WordPress network, there might be additional things required so please do not use the above steps if you run WordPress Multi-site version.</em></p>
</div>

</div>
      
      <div class="info bottom">
      
      
        
      </div>
      
      <?php wp_nonce_field( '_theme_options', '_ajax_nonce', false ); ?>
    
    
  </div>

</div>
<!-- [END] framework_wrap -->