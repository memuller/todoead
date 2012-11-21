<?php 
// =============================== City wise Widget (particular category) ======================================
class onecolumnslist extends WP_Widget {
	function onecolumnslist() {
	//Constructor
		$widget_ops = array('classname' => 'widget category List View', 'description' => 'List of latest posts in particular category - ( Front content )' );
		$this->WP_Widget('onecolumnslist', 'City Deals', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
	   // print_r($this->['name']); exit;
	  // echo $title;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$user_db_table_name = get_user_table(); 
		$status_deal = empty($instance['status_deal']) ? '' : apply_filters('widget_status_deal', $instance['status_deal']); ?>
		<div class="sbox side-invite-tip">      
      	<div class="sbox-top"></div>      
          <div class="sbox-content">	 
            <div style="height:auto" class="body">
        
        <h3 class="deal_widget_title"><?php echo $title; ?> <small> ( <a href="<?php echo site_url();?>/?dwtype=taxonomy_live_deal_tab" class="b_viewalldeal"><?php _e(VIEW_ALL_DEAL,'ddb_wp');?></a> ) </small> </h3>
       
		<span class="flip_postion"></span>
		<div class="deals_widget">
  <!-- BOF Loop -->
			<?php DDBWP_page_title_above(); //page title above action hook?>
			<?php  $destination_path = site_url().'/wp-content/uploads/'; ?>
			<script type="text/javascript" src="<?php echo DDB_PUGIN_URL;?>/js/timer.js"></script>
 <?php 		global $wp_query, $post, $wpdb;
 			$main_deal_id = $post->ID;
			$current_term = $wp_query->get_queried_object();	
			if( $current_term->name)	{
				$ptitle = $current_term->name; 
			}	 ?>
			<div id="loop" class="<?php if (get_option('ptttheme_view_opt') == 'Grid View') {  echo 'grid'; }else{ echo 'list clear'; } ?> ">
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
<?php 	if((get_post_meta($post->ID,'enddate',true) == '0' ) && get_option('ptttheme_view_opt') != 'Grid View' && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2') ) { 
		
		?>
		<?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal" target="_blank"><?php echo BUY_NOW ;?></a>
		<?php 		} else { ?>
						<a href="#" title="<?php echo BUY_NOW ;?>" class="btn_buy_deal contact"><?php echo BUY_NOW ;?></a>
		<?php 		}
				}?>
<?php 						if(get_post_meta($post->ID,'is_expired',true) != 1 && get_option('ptttheme_view_opt') == 'Grid View') {
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
						$percentsave = $percent/$current_price;
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
		<?php 	if(get_post_meta($post->ID,'enddate',true) == '0' && get_option('ptttheme_view_opt') != 'Grid View' && (get_post_meta($post->ID,'status',true) == '1' || get_post_meta($post->ID,'status',true) == '2') && get_post_meta($post->ID,'is_expired',true) == '0' ) { 
		
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
	
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['status_deal'] = strip_tags($new_instance['status_deal']);
		
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '', 'status_deal' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$status_deal = strip_tags($instance['status_deal']);
		
		

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo WID_TITLE;?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo WID_CATEGORY_DESC;?>
    <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo attribute_escape($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo WID_NO_POST;?>
    <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('status_deal'); ?>">
    <?php echo DISPLAY_OPTION; ?>
  </label>
  <select id="<?php echo $this->get_field_id('status_deal'); ?>" name="<?php echo $this->get_field_name('status_deal'); ?>">
    <?php 
		if($status_deal == 'all'){
			$all_selected = 'selected';
		}
		else{
			$all_selected = '';
		}
		if($status_deal == 'expire'){
			$all_expire = 'selected';
		}
		else{
			$all_expire = '';
		}
		?>
    <option value="all" <?php echo $all_selected; ?>><?php echo SHOW_ALL_DEAL;?></option>
    <option value="expire" <?php echo $all_expire; ?>><?php echo HIDE_EXPIRE_DEAL;?></option>
  </select>
</p>
<?php
	} 
}

 ?>
