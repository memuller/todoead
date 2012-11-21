<?php 
echo '<div class="tabbertab" style="margin-top:20px;">';
		if($dealcnt_sql) {
			
			foreach( $dealcnt_sql as $post ){ //echo wp_get_recent_posts($post);
				//deal_expire_process($post->ID); 
				echo get_post_meta($post->ID,'our_price',true); die;
				$coupon_website= get_post_meta($post->ID,'coupon_website',true);
				$owner_name= get_post_meta($post->ID,'owner_name',true);
				$our_price= get_post_meta($post->ID,'our_price',true);
				$current_price= get_post_meta($post->ID,'current_price',true);
				$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1"; 
				$totdiff = $current_price - $our_price;
				$percent = $totdiff * 100;				
				$percentsave = (empty($current_price) || $current_price==0)?0:$percent/$current_price;
                $sellsqlinfo = $wpdb->get_var($sellsql);
				$date = get_post_meta($post->ID,'coupon_end_date_time',true);
				if(get_post_meta($post->ID,'coupon_end_date_time',true) != ''){
					$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
					$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
				} if(get_post_meta($post->ID,'coupon_start_date_time',true) != ''){
					$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
				}
				$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true);?> 
				<div class="posts_deals"> 
					<div class="product_image">
						<a href="#" onclick="viewtransaction(<?php _e($post->post_author,'ddb_wp'); ?>,<?php _e($post->ID,'ddb_wp'); ?>)">
			<?php 			if(get_post_meta($post->ID,'file_name',true) != "") {?>
								<img src="<?php echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=165&amp;h=180&amp;zc=1&amp;q=80');?>" alt="" />
			<?php 			} else { ?>
							<img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=165&amp;h=180&amp;zc=1&amp;q=80');?>" alt="" />
								
					<?php 	} ?></a>
					</div>
                    <div class="content_right content_right_inner">
			
                    <span class="title_yellow"><?php echo TODAY_DEAL;?></span><span class="title_grey"><?php echo PROVIDE_BY;?> </span>
			<?php	$user_data = $wpdb->get_row("select * from $user_db_table_name where ID = '".$post->post_author."'"); ?>
					<a href="<?php echo DDBWP_get_author_posts_url($post->post_author);?>" onclick="viewauthor(<?php echo $post->post_author; ?>,1)" class="top_lnk" title="<?php echo $user_data->display_name; ?>"><?php echo get_post_meta($post->ID,'owner_name',true); ?></a>
					<h3><?php echo $post->post_title; ?></h3>
	        <?php 	if(get_post_meta($post->ID,'coupon_end_date_time',true) != '') {
						if(get_post_meta($post->ID,'is_expired',true) == '1' || get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo || date("Y-m-d H:i:s")>= date("Y-m-d H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true)) ) {
							if(get_post_meta($post->ID,'is_expired',true)== '0'){
							update_post_meta($post->ID,'is_expired','1');
							}?>
							<div class="i_expire"><?php echo THIS_DEAL;?><span><?php echo EXPIRED;?></span> <?php echo ON;?> <span><?php echo $tardate1;?></span></div>
			<?php  		} else  { 
							if(get_post_meta($post->ID,'coupon_end_date_time',true)) { ?> 
								<div id="demo" style="pointer-events:none; cursor:default;">
									<div id="slider-range-min"  ></div>
								</div>
								<div class="deal_time_box">
									<div class="time_line"></div>
									<div id="countdowncontainer_author_<?php _e($post->ID,'ddb_wp'); ?>"></div>
									<script type="text/javascript">
									var dealexpire = new cdtime("countdowncontainer_author_<?php _e($post->ID,'ddb_wp'); ?>", "<?php echo $tardate; ?>")
								dealexpire.displaycountdown("days", formatresults)
								</script>
									<div class="fr">
                                    <div class="price_main">
                                    <span class="strike_rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price;?></span> 
                                    <span class="rate"><?php echo get_post_currency_sym($post->ID);?><?php echo $our_price;?></span> 
                                    </div>
									<?php if(get_post_meta($post->ID,'coupon_type',true) == 1) { ?>
								<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="Buy now!" class="btn_buy " target="_blank"><?php _e(BUY_NOW,'ddb_wp');?></a>
							<?php } else { ?>
								<a href="#" title="Buy now!" class="btn_buy contact"><?php _e(BUY_NOW,'ddb_wp');?></a>
							<?php }?>
									</div>
								</div>
			<?php 			} 
						}
					} ?>
                    <ul class="rate_summery">
                        <li class="rate_current_price"><span><?php echo CURRENT_PRICE;?></span> 
                        <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $current_price;?></strong></li>
                        <li class="rate_our_price"><span><?php echo OUR_PRICE;?></span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo $our_price;?></strong></li>
                        <li class="rate_percentage"><span><?php echo YOU_SAVE;?></span> <strong><?php echo @number_format($percentsave,2);?>%</strong></li>
						<?php if(get_post_meta($post->ID,'shipping_cost',true) > 0 ) {?>
						<li class="rate_our_price"><span>
						<?php echo SHIPPING_COST;?>
						</span> <strong><small><?php echo get_post_currency_sym($post->ID);?></small><?php echo get_post_meta($post->ID,'shipping_cost',true);?></strong></li>
						<?php } ?>
                        <li class="bdr_none rate_item_sold"><span><?php echo ITEMS_SOLD;?></span> <strong><?php echo $sellsqlinfo;?></strong>
				<?php 	if($sellsqlinfo == 0 ) { 
							$enddate = explode(" ",$tardate); 
							$curdate = explode(" ",date("F d, Y H:i:s"));
							$enddate= str_replace(",","",$enddate[1]);
							$curdate =  str_replace(",","",$curdate[1]);
							$startdate = explode(" ",$stdate);
							$strdate = str_replace(","," ",$startdate[1]);
							$curtime = $enddate - $curdate;
							$totaltime =  ($enddate - $strdate);
							$nowremail = $curdate - $strdate; ?>
							<input type="hidden" value="<?php echo $nowremail ; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
							<input type="hidden" value="<?php  echo ($enddate - $strdate) ; ?>" name="noofcoupon" id="noofcoupon"/>
				<?php 	} else{  ?>
							<input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo" id="sellsqlinfo"/>
							<input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon" id="noofcoupon"/>
				<?php 	} ?>
						</li>
                    </ul>
                    
                    
                     <?php if(DDBWP_is_show_post_category()){?>
					  <div class="post_cats clearfix"> 
                       <?php the_taxonomies(array('before'=>'<span class="categories">','sep'=>'</span><span class="tags">','after'=>'</span>')); ?> 
                       </div>
                     <?php } ?>
                    
                    
					<div class="text_content" id="content_<?php _e($post->ID,'ddb_wp');?>">
				 <?php echo "".$post->post_excerpt."";  ?><a href="<?php the_permalink(); ?>" class="readmore_link"><?php _e(get_option('ddbwpthemes_content_excerpt_readmore'));
						?> </a>
    
					</div>
					
                </div>  
            </div>
	<?php  	} 
			if($total_pages>$recordsperpage) {
				echo '<div style="text-align:right" >'.get_pagination($targetpage,$total_pages,$recordsperpage,$pagination).'</div>';
			}
		} else {
			echo NO_DEAL_PROVIDED;
		} ?>
	</div>