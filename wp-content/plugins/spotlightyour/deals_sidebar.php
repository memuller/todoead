<div id="sidebar">
	<div id="login-box">
    <h3><?php echo apply_filters('DDBWP_login_widget_myaccount_text_filter',__('Quick Links','ddb_wp'));?></h3>
    <ul class="blogroll">
	<?php
		global $current_user;
		if($current_user->ID)
		{	
				$authorlink = get_author_link($echo = false, $current_user->data->ID);
				
				echo apply_filters('DDBWP_login_widget_dashboardlink_filter','<li><a href="'.$authorlink.'">'.__('My Account','ddb_wp').'</a></li>');
				echo apply_filters('DDBWP_login_widget_editprofilelink_filter','<li><a href="'.site_url('/?dwtype=profile').'">'.__('Edit Profile','ddb_wp').'</a></li>');
				echo apply_filters('DDBWP_login_widget_logoutlink_filter','<li><a href="'.wp_logout_url(get_option('siteurl')).'">'.__('Logout','ddb_wp').'</a></li>');
	?>			
    <?php }else{ ?> 
    		<li><a href="<?php echo get_option('siteurl');?>/?dwtype=login">Sign In</a></li>  
            <li><a href="<?php echo get_option('siteurl');?>/?dwtype=login">Sign Up Now?</a></li>       
    <?php } ?>    
    </ul>	
    </div>
    <?php $subscriber_page = get_page_by_title( "E-mail Subscriptions" );
			$args = array(
						 'show_option_all' => "Select Your City",
						 'taxonomy' => CUSTOM_CATEGORY_TYPE1,
						 'name'     => CUSTOM_CATEGORY_TYPE1
					 );
	?>
      <div class="deal-subscribe clear">
      <div class="top"><div class="result"></div></div>
      <div id="deal-subscribe-body" class="body"> 		
      <form accept-charset="utf-8" onsubmit="return validateSubmit(this);" action="<?php echo site_url()."/?dwtype=subscribe";?>" method="post" id="deal-subscribe-form">
     <?php wp_dropdown_categories($args);?>
      <table class="address" width="20%">
          <tbody>
         
          <tr>
            <td><input type="text" id="subscriber_email" class="f-text" name="subscriber_email" value="Enter Email Address" onfocus="setText(this, 'Enter Email Address')" onblur="setText(this, 'Enter Email Address')" onclick="setText(this, 'Enter Email Address')"></td>
            <td align="center"><span class="aloader"><img src="<?php echo DDB_PUGIN_URL."/images/";?>loading.gif" /></span><span class="sbutton"><input type="image" value="Submit" src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/button-subscribe.gif" onclick="submit_subs()"></span></td>
          </tr>
        </tbody></table>
        <p class="text"><?php _e('Please enter your e-mail address to subscribe','ddb_wp')?>.<br>
          <span class="required">*</span> <?php _e('You can unsubscribe','ddb_wp')?><br>
          <?php _e('at any time','ddb_wp')?></p>
      </form></div>
       </div>
       <script language="javascript">
	   //<!--
	   
	   function setText(obj, def_text){
		   if(obj.value == '')
		   	obj.value =def_text;
		  if(obj.value == def_text)	
		  	obj.value ="";		  	
	   }
	   function submit_subs(){
		   var subs_email = $('#subscriber_email').val();
		  var subs_cat = $('#seller_category').val();
		  
		  if(subs_cat == '' || subs_cat == "0"){
				alert('Please choose City');
				$('#seller_category').focus();  
				return false;
		  }
		  
		  if(subs_email == '' || subs_email == 'Enter Email Address'){
				alert('Please enter your Email');
				$('#deal-subscribe-form-email').focus();  
				return false;
		  }
		  
		  $('.sbutton').hide();
		  $('.aloader').show();
		$.ajax({
		  url: '<?php echo DDB_PUGIN_URL."/email_subscribe.php";?>',
		  data: {seller_category:subs_cat,subscriber_email:subs_email},
		  type:"POST",
		  dataType:"html",		  
		  success: function(rdata) {
			$('.sbutton').show();
		    $('.aloader').hide();
			$('.result').html(rdata);
			//alert(data);
		  }
		});   
		
	   }
	   function validateSubmit(obj){
		   return false;
		  var subs_email = $('#deal-subscribe-form-email').val();
		  var subs_cat = $('#seller_category').val();
		  
		  if(subs_cat == ''){
				alert('Please choose City');
				$('#seller_category').focus();  
				return false;
		  }
		  
		  if(subs_email == ''){
				alert('Please enter your Email');
				$('#deal-subscribe-form-email').focus();  
				return false;
		  }
	   }
	   //-->
	   </script>
         
     <?php
	  {
	
		$post_number =  '2';
		$user_db_table_name = get_user_table(); 
		$status_deal = 'A'?>
		<div class="sbox side-invite-tip">      
      	<div class="sbox-top"></div>      
          <div class="sbox-content">	 
            <div style="height:auto" class="body">
        
        <h3 class="deal_widget_title"><small> ( <a href="<?php echo site_url();?>/?dwtype=taxonomy_live_deal_tab" class="b_viewalldeal"><?php _e(VIEW_ALL_DEAL,'ddb_wp');?></a> ) </small> </h3>
       
		<span class="flip_postion"></span>
		<div class="deals_widget">
  <!-- BOF Loop -->			
<?php  		$destination_path = site_url().'/wp-content/uploads/'; 		
			global $wp_query, $post, $wpdb;
 			$main_deal_id = $post->ID;
			$current_term = $wp_query->get_queried_object();	
			if( $current_term->name)	{
				$ptitle = $current_term->name; 
			}	 ?>
			<div id="loop" class="<?php if (get_option('ddbwpthemes_view_opt') == 'Grid View') {  echo 'grid'; }else{ echo 'list clear'; } ?> ">
    <!-- BOF All Deal -->
<?php  			global $wpdb,$transection_db_table_name;
				$targetpage = site_url("?dwtype=deals");
				$postmeta_db_table_name = $wpdb->prefix . "postmeta";
				$post_db_table_name = $wpdb->prefix . "posts";
				$sql = "select p.* from $post_db_table_name p  LEFT JOIN $postmeta_db_table_name pm ON pm.post_id=p.ID where p.post_type = 'seller' and p.post_status = 'publish' AND (pm.meta_key = 'is_expired' AND pm.meta_value = 0)";
				$total_deals = mysql_query($sql);
				$total_pages = mysql_num_rows($total_deals);
				$recordsperpage = $post_number;
				$pagination = $_REQUEST['pagination'];
				if($pagination == '') {
					$pagination = 1;
				}
				$strtlimit = ($pagination-1)*$recordsperpage;
				$endlimit = $strtlimit+$recordsperpage;
				if($category) {
					$category = "'".str_replace(",","','",$category)."'";
					$sqlsql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  ) AND p.ID !=$main_deal_id";
				}
				$dealcnt_sql = $wpdb->get_results("select p.* from $post_db_table_name p LEFT JOIN $postmeta_db_table_name pm ON pm.post_id=p.ID where p.post_type = 'seller' and p.post_status = 'publish'  AND p.ID !=$main_deal_id AND (pm.meta_key = 'is_expired' AND pm.meta_value = 0) $sqlsql ORDER BY ID DESC  limit $strtlimit,$recordsperpage ");
				if(count($dealcnt_sql) > 0 ) {
				$pcount = 0;
				foreach( $dealcnt_sql as $post ){
					
					if( $status_deal == 'all'){
					$expired = get_post_meta($post->ID,'is_expired',true) =='1' || get_post_meta($post->ID,'is_expired',true) =='0';
				}
				else{
					$expired = get_post_meta($post->ID,'is_expired',true) =='0';
				}
				if($status_deal == 'all'){
					$pcount ++;
					if(get_post_meta($post->ID,'enddate',true)!='0')
						deal_expire_process($post->ID); 
					$coupon_website= get_post_meta($post->ID,'coupon_website',true);
					$owner_name= get_post_meta($post->ID,'owner_name',true);
					$our_price= get_post_meta($post->ID,'our_price',true);
					$current_price= get_post_meta($post->ID,'current_price',true);
					$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
					$totdiff = $current_price - $our_price;
					$percent = $totdiff * 100;
					$percentsave = $percent/$current_price;
					$sellsqlinfo = $wpdb->get_var($sellsql);
					if(get_post_meta($post->ID,'enddate',true) != '0'){
					if(get_post_meta($post->ID,'coupon_end_date_time',true) != "")	{
					$date = get_post_meta($post->ID,'coupon_end_date_time',true);
					$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
					$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
					$enddate1 = date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
						if(date("Y-m-d H:i:s") >= $enddate1 && get_post_meta($post->ID,'enddate',true) != '0') {
							if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
								update_post_meta($post->ID,'is_expired','1');
							}
						}
					} else {
					if(get_post_meta($post->ID,'enddate',true) != '0' && get_post_meta($post->ID,'no_of_coupon',true) == $sellsqlinfo) {
						if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
							update_post_meta($post->ID,'is_expired','1');
						}
					}
					} }
					$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
					$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true); ?>
					<div <?php post_class('post posts_deals'); ?> id="post_<?php the_ID(); ?>" >
						<div class="product_image "> <a href="<?php the_permalink(); ?>">
<?php 						if(get_post_meta($post->ID,'file_name',true) != "") { ?>
								<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=160&amp;h=80&amp;zc=1&amp;q=80');?>" alt="" />
<?php 						}  else {	?>
								<img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=160&amp;h=80&amp;zc=1&amp;q=80');?>" alt="" />
<?php 						} ?>
						</a></div>
						<div class="product_image grid_img"> <a href="<?php the_permalink(); ?>">
<?php 						if(get_post_meta($post->ID,'file_name',true) != "") { ?>
								<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=180&amp;h=80&amp;zc=1&amp;q=80');?>" alt="" />
<?php	 					} else {	?>
									<div class="noimg"><?php _e('Image <br />not available','ddb_wp');?></div>
<?php 						} ?>
						</a> </div>
						<div class="content_right content_right_inner"><span class="title_grey"><?php _e(PROVIDE_BY,'ddb_wp');?></span>
<?php						$user_db_table_name = get_user_table();
							$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '".$post->post_author."'"); ?>
							<a href="<?php echo get_author_posts_url($post->post_author);?>" class="top_lnk" title="<?php echo $user_data->display_name; ?>"><?php echo get_post_meta($post->ID,'owner_name',true); ?></a>
							<h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h3>
							<div class="grid_price"><span class="strike_rate"><?php _e('Our Price :','ddb_wp');?> <s><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price;?></s></span> <span class="rate"><?php _e('Offer Price :','ddb_wp');?> <?php echo get_post_currency_sym($post->ID);?><?php echo $our_price;?></span> </div>
<?php 						if(date("Y-m-d H:i:s")>= $enddate1)	{
								if(get_post_meta($post->ID,'is_expired',true)=='1' || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo)	{
									?>
									<div class="i_expire"><?php echo THIS_DEAL;?><span><?php echo EXPIRED;?></span> <?php echo ON;?> <span><?php echo $tardate1;?></span></div>
<?php 							}
							} else    { 
								if(get_post_meta($post->ID,'coupon_end_date_time',true) && 0 ) {  ?>
									<div class="deal_time_box">
										<div class="time_line"> </div>
											<div id="countdowncontainer_<?php _e($post->ID,'ddb_wp'); ?>"></div>
											<script type="text/javascript">
											var dealexpire=new cdtime("countdowncontainer_<?php _e($post->ID,'ddb_wp'); ?>", "<?php echo $tardate; ?>")
											dealexpire.displaycountdown("days", formatresults)
											</script>
											<div class="fr">
												<div class="price_main"> <span class="strike_rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price;?></span> <span class="rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $our_price;?></span> </div>
												<?php if(get_post_meta($post->ID,'coupon_type',true) == 1 ) { ?>
												<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy" target="_blank"><?php echo BUY_NOW ;?></a>
												<?php } else { ?>
												<a href="#" title="<?php echo BUY_NOW ;?>" class="btn_buy contact"><?php echo BUY_NOW ;?></a>
												<?php }?>
											</div>
									</div>
<?php 							} 
							}?>
							<ul class="rate_summery">
								<li class="rate_current_price"><span><?php echo CURRENT_PRICE;?></span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $current_price;?></strong></li>
								<li class="rate_our_price"><span><?php echo OUR_PRICE;?></span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $our_price;?></strong></li>
								<li class="rate_percentage"><span><?php echo YOU_SAVE;?></span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
								<li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD;?></span> <strong><?php echo $sellsqlinfo;?></strong>
							</ul>
<?php 						/*$post_categories = wp_get_post_terms($post->ID,'seller_city');
							if($post_categories[1]  != ""){	?>
								<div class="post_cats clearfix">
<?php 							the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?>
								</div>
<?php 						} */?>
<?php 	if((get_post_meta($post->ID,'enddate',true) == '0' ) && get_option('ddbwpthemes_view_opt') != 'Grid View' && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2') ) { 
		
		?>
		<?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW ;?></a>
		<?php 		} else { ?>
						<a href="#" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal contact"><?php echo BUY_NOW ;?></a>
		<?php 		}
				}?>
<?php 						if(get_post_meta($post->ID,'is_expired',true) != 1 && get_option('ddbwpthemes_view_opt') == 'Grid View') {
								if(get_post_meta($post->ID,'coupon_type',true) == 1) {		
								 ?>
								 <a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy_grid"><?php echo BUY_NOW ;?></a>
								
<?php 						} else { ?>
								<a href="#" title="<?php echo BUY_NOW ;?>" class="btn_buy_grid contact"><?php echo BUY_NOW ;?></a>
<?php						} }?>
							<!--<div class="text_content"  id="content_<?php _e($post->ID,'ddb_wp');?>"><?php echo "".$post->post_excerpt."";  ?><a href="<?php the_permalink(); ?>" class="readmore_link"><?php _e(get_option('ddbwpthemes_content_excerpt_readmore'));?></a></div>-->
						</div>
					</div>
                    
<?php  				$page_layout = DDBWP_get_page_layout();
					if ($pcount == 3){
						$pcount=0; ?>
						<div class="hr clear"></div>
<?php   			}
				} else {
					if(get_post_meta($post->ID,'is_expired',true) != 1) {
						$pcount ++;	
					if(get_post_meta($post->ID,'enddate',true) != '0'){						
						deal_expire_process($post->ID); 
						}
						$coupon_website= get_post_meta($post->ID,'coupon_website',true);
						$owner_name= get_post_meta($post->ID,'owner_name',true);
						$our_price= get_post_meta($post->ID,'our_price',true);
						$current_price= get_post_meta($post->ID,'current_price',true);
						$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
						$totdiff = $current_price - $our_price;
						$percent = $totdiff * 100;
						$recordsperpage = $post_number;
						$percentsave = empty($current_price)?0:$percent/$current_price;
						$sellsqlinfo = $wpdb->get_var($sellsql);
						if(get_post_meta($post->ID,'enddate',true) != '0'){
						if(get_post_meta($post->ID,'coupon_end_date_time',true) != "")
						{
						$date = get_post_meta($post->ID,'coupon_end_date_time',true);
						$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
						$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
						$enddate1 = date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
						if(date("Y-m-d H:i:s") >= $enddate1 && get_post_meta($post->ID,'enddate',true) != '0') {
							if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
								update_post_meta($post->ID,'is_expired','1');
							}
						}
						} else {
						if(get_post_meta($post->ID,'enddate',true) != '0' && get_post_meta($post->ID,'no_of_coupon',true) == $sellsqlinfo) {
							if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
								update_post_meta($post->ID,'is_expired','1');
							}
						}
						}}
						$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
						$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true);?>
						<div <?php post_class('post posts_deals'); ?> id="post_<?php the_ID(); ?>" >
							<div class="product_image "> <a href="<?php the_permalink(); ?>">
<?php 							if(get_post_meta($post->ID,'file_name',true) != "") { ?>
									<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=160&amp;h=80&amp;zc=1&amp;q=80');?>" alt="" />
<?php 							} else { ?>
										<img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=260&amp;h=180&amp;zc=1&amp;q=80');?>" alt="" />
<?php 							} ?>
							</a> </div>
							<div class="product_image grid_img"> <a href="<?php the_permalink(); ?>">
<?php 							if(get_post_meta($post->ID,'file_name',true) != "") { ?>
									<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=180&amp;h=80&amp;zc=1&amp;q=80');?>" alt="" />
<?php 							} else{ ?>
									<div class="noimg"> <?php _e('Image <br /> not available','ddb_wp'); ?></div>
<?php 							} ?>
							</a> </div>
							<div class="content_right content_right_inner"><?php if(get_option('ddbwpthemes_listing_author') != 'No') {?>        
                   <span class="title_grey"><?php echo PROVIDE_BY;?> </span>
					<?php
					$user_db_table_name = get_user_table();
					$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '".$post->post_author."'");
					 ?>
					
					<a href="<?php echo get_author_posts_url($post->post_author);?>" class="top_lnk" title="<?php echo $user_data->display_name;?>"><?php echo get_post_meta($post->ID,'owner_name',true);?></a>
					<?php } ?>
								<h3><a href="<?php the_permalink(); ?>"><?php echo $post->post_title; ?></a></h3>
								<div class="grid_price"><span class="strike_rate"><?php _e(OUR_PRICES,'ddb_wp');?><s><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price;?></s></span> <span class="rate"><?php _e(OFFER_PRICE,'ddb_wp');?> <?php echo get_post_currency_sym($post->ID);?><?php echo $our_price;?></span>
							</div>
<?php 						
							if(get_post_meta($post->ID,'enddate',true) != '0'){
							if(date("Y-m-d H:i:s")>= $enddate1) {
								if(get_post_meta($post->ID,'is_expired',true)=='1' || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo){
									if(get_post_meta($post->ID,'is_expired',true)== '0'){
										update_post_meta($post->ID,'is_expired','1');
									}?>
									<div class="i_expire"><?php echo THIS_DEAL;?><span><?php echo EXPIRED;?></span> <?php echo ON;?> <span><?php echo $tardate1;?></span></div>
<?php 							}
							} else { 
								if(get_post_meta($post->ID,'coupon_end_date_time',true)) { ?>
									<div class="deal_time_box">
										<div class="time_line"> </div>
										<div id="countdowncontainer_<?php _e($post->ID,'ddb_wp'); ?>"></div>
										<script type="text/javascript">
										var dealexpire=new cdtime("countdowncontainer_<?php _e($post->ID,'ddb_wp'); ?>", "<?php echo $tardate; ?>")
										dealexpire.displaycountdown("days", formatresults)
										</script>
										<div class="fr">
											<div class="price_main"> <span class="strike_rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price;?></span> <span class="rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $our_price;?></span> </div>
<?php 										if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
												<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php _e(BUY_NOW,'ddb_wp');?>" class="btn_buy" target="_blank"><?php _e(BUY_NOW,'ddb_wp');?></a>
<?php 										} else { ?>
												<a href="#" title="<?php _e(BUY_NOW,'ddb_wp');?>" class="btn_buy contact"><?php _e(BUY_NOW,'ddb_wp');?></a>
<?php 										} ?>
										</div>									
<?php 							} ?>
<?php						} } ?>
        <ul class="rate_summery">
          <li class="rate_current_price"><span>
            <?php echo CURRENT_PRICE;?>
            </span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $current_price;?></strong></li>
          <li class="rate_our_price"><span>
            <?php echo OUR_PRICE;?>
            </span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $our_price;?></strong></li>
          <li class="rate_percentage"><span>
            <?php echo YOU_SAVE;?>
            </span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
          <li class="bdr_none rate_item_sold"><span>
            <?php echo ITEMS_SOLD;?>
            </span> <strong><?php echo $sellsqlinfo;?></strong> </li>
        </ul>
        <?php if(DDBWP_is_show_post_category()){?>
        <div class="post_cats clearfix">
          <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?>
        </div>
        <?php } ?>
		<?php 	if(get_post_meta($post->ID,'enddate',true) == '0' && get_option('ddbwpthemes_view_opt') != 'Grid View' && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2') && get_post_meta($post->ID,'is_expired',true) == '0' ) { 
		
		?>
		<?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW;?></a>
		<?php 		} else { ?>
						<a href="#" title="<?php echo BUY_NOW;?>" class="btn_buy_deal contact"><?php echo BUY_NOW; ?></a>
		<?php 		}
				}?>
        <?php if(get_post_meta($post->ID,'is_expired',true) != 1) { 
			if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
        <a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" onclick="" title="<?php echo BUY_NOW;?>" class="btn_buy_grid"><?php echo BUY_NOW;?></a>
        <?php } else { ?>
				 <a href="#" title="<?php echo BUY_NOW;?>" class="btn_buy_grid contact"><?php echo BUY_NOW;?></a>
		<?php	}
			}?>
       <!-- <div class="text_content"  id="content_<?php _e($post->ID,'ddb_wp');?>">
          <?php echo "".$post->post_excerpt."";  ?>
          <a href="<?php the_permalink(); ?>" class="readmore_link">
          <?php _e(get_option('ddbwpthemes_content_excerpt_readmore'));?>
          </a> </div>-->
      </div>
    </div>
    <?php  
			  $page_layout = DDBWP_get_page_layout();
					if ($pcount == 3){
						$pcount=0; ?>
    <div class="hr clear"></div>
 <?php

			}	}		  
				}
			 
			  }
				}
			  ?>
              
    <!-- EOF All Deal -->
   
    </div>  
    </div>
     </div> 
     </div> 
    <div class="sbox-bottom" style="margin-top:0"></div>  
     
  			 

</div>  
   
<!--  CONTENT AREA END -->
<?php
 }   
	 ?>  
       
	<?php if ( is_active_sidebar( 'deals-right-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'deals-right-sidebar' ); ?>
	<?php endif; ?>
</div>  