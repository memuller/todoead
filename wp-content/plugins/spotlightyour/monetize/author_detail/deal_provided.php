<?php global $wpdb,$deal_db_table_name, $post;?>
	<h2><a href="#?totaldeal=1"><?php echo DEAL_PROVIDED;?></a></h2>						  
<?php	if(mysql_affected_rows() >0){
			echo '<ul class="deal_listing">';			
			$preserving_post = get_the_ID();
			foreach($dealcnt_sql as $total_deals_obj){ $post=$total_deals_obj; $start_date = get_post_meta(get_the_id(),'coupon_start_date_time',true); //if(empty($start_date)) continue;?>
				<li>
					<div class="posts_deal">	
						<div class="product_image"><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)">
			<?php 		if(get_post_meta($total_deals_obj->ID,'file_name',true) != "") {?>
							<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($total_deals_obj->ID,'file_name',true),'&amp;w=145&amp;h=160&amp;zc=1&amp;q=80');?>" alt="deal image" />
			<?php 		} else { ?>
							<img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=145&amp;h=160&amp;zc=1&amp;q=80');?>" alt="deal image" />
							
			<?php 		}?></a>
						</div>
						<div class="content">
							<h3><span class="dealtitle"><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)"><?php echo $total_deals_obj->post_title;?></a></span>
							<span class="price"><?php echo STATUS; ?> : <?php  fetch_status(get_post_meta($total_deals_obj->ID,'status',true),get_post_meta($total_deals_obj->ID,'is_expired',true)); ?></span></h3>
							
			<?php 			
			//echo " //get_post_meta(".get_the_id().",'coupon_start_date_time',true) =>".get_post_meta(get_the_id(),'coupon_start_date_time',true); die;
			if(get_post_meta($total_deals_obj->ID,'coupon_end_date_time',true) != '') {
								echo '<strong>'.DEAL_DURATION." : <br /> From : </strong> ".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_start_date_time',true))."&nbsp;&nbsp; | &nbsp;<strong> To : </strong> ".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_end_date_time',true));
							} else {
								echo "DEAL start from : ".date("F d,Y H:i:s",get_post_meta($total_deals_obj->ID,'coupon_start_date_time',true));
							}?>
							<ul class="deal_li">
								<li><span class="field"><?php echo DEAL_COUPON_TEXT; ?></span><span>: <?php fetch_deal(get_post_meta($total_deals_obj->ID,'coupon_type',true));?></span></li>											
								<li><span class="field"><?php echo DEAL_POST_TEXT; ?></span><span>: <?php echo $total_deals_obj->post_date;?></span></li>						
								<li><span class="field"><?php echo DEAL_NUM_OF_TEXT; ?></span><span>: <?php echo get_post_meta($total_deals_obj->ID,'no_of_coupon',true);?></span></li>
								<li><span class="field"><?php echo DEAL_CPRICE_TEXT; ?></span><span>:  <?php echo get_post_currency_sym($post->ID).get_post_meta($total_deals_obj->ID,'current_price',true);?></span></li>
								<li><span class="field"><?php echo DEAL_PRICE_TEXT; ?></span><span>: <?php echo get_post_currency_sym($post->ID).get_post_meta($total_deals_obj->ID,'our_price',true);?></span></li>		
							</ul>
							<p class="deallistinglinks">
								<span class="link"><?php echo DEAL_WEBLINK_TEXT; ?> : <a href="<?php echo get_post_meta($total_deals_obj->ID,'coupon_website',true);?>" title="<?php echo $total_deals_obj->coupon_website;?>" target="_blank"><?php echo get_post_meta($total_deals_obj->ID,'coupon_website',true);?></a></span>
								<?php 
									if($current_user->ID != '0' && $current_user->ID == $UID) {
										$table_setup = $wpdb->prefix."deal_setup";
										$sqlsetup = $wpdb->get_row("select * from $table_setup where sid='1'");
										if($sqlsetup->access == '1')	{
											if($total_deals_obj->post_status == 'draft' || get_post_meta($total_deals_obj->ID,'status',true) == '0' || get_post_meta($total_deals_obj->ID,'is_expired',true) == '1')  { ?>
												<span class="action_link"><a href="?dwtype=dealform&amp;editdeal=<?php _e($total_deals_obj->ID,'ddb_wp');?>" class="edit" ><?php echo Edit; ?></a></span>  |
												<span class="action_link">| <a href="javascript:void(0);delete_deal('<?php _e($total_deals_obj->ID,'ddb_wp');?>');" class="delet" ><?php echo Delete; ?></a> |</span>
										<?php } 
										} ?>
										<span class="action_link"><a href="#" onclick="viewtransaction(<?php echo $UID ;?>,<?php echo $total_deals_obj->ID;?>)"><?php echo VIEW_TRANSACTIONS; ?></a></span> 
							<?php 	} ?>
							</p>
						</div>
					</div>
				</li>					
		 <?php }
		 $post = $preserving_post;
			echo '</ul>';
				if($total_pages>$recordsperpage){
					echo '<div style="text-align:right" >'.get_pagination($targetpage,$total_pages,$recordsperpage,$pagination).'</div>';
				}
			} else {
				echo NO_DEAL_PROVIDED;
			} ?>