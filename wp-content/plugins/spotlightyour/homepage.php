<?php
$theme = get_option('ddbwpthemes_alt_stylesheet');


/* Mail To Friend EOF */
/* Home Page Deal Display BOF */
global $wpdb,$deal_db_table_name;	
$postmeta_db_table_name = $wpdb->prefix."postmeta";
$post_db_table_name = $wpdb->prefix."posts";
$destination_path = site_url().'/wp-content/uploads/';
$args = array(/*'numberposts' => 1,*/'meta_key' =>'is_expired' , 'meta_value' =>'0','post_status' => 'publish','post_type' => 'seller','meta_key' =>'status' , 'meta_value' =>'2' ,'orderby' => 'DESC');

$recent_posts = get_posts( $args ); 


if(mysql_affected_rows() > 0) { // 1st IF Condition BOF
	$post_large = bdw_get_images($destination_path.get_post_meta($post->ID,'file_name',true),'large');
	$post_images = bdw_get_images($destination_path.get_post_meta($post->ID,'file_name',true),'thumb');
	
	$limit = count($recent_posts)-1;
	$i = rand(0,$limit);
	$post = $recent_posts[$i];
	// foreach( $recent_posts as $post )
	{  // foreach loop BOF

		if((get_post_meta($post->ID,'status',true) == 2) && (get_post_meta($post->ID,'is_expired',true) == 0)) { 
			if(get_post_meta($post->ID,'enddate',true) != '0'){
				deal_expire_process($post->ID); 
			}
			
			$home_deal_id = $post->ID;
			global $home_deal_id;
			//Coupon Website
			$coupon_website= get_post_meta($post->ID,'coupon_website',true);
			//Seller
			$owner_name= get_post_meta($post->ID,'owner_name',true);
			//Offer Price
			$our_price= get_post_meta($post->ID,'our_price',true);
			//Real Price
			$current_price= get_post_meta($post->ID,'current_price',true);
			//Sold Item
			$sellsql = "select count(*) from $transection_db_table_name where post_id=".$post->ID." and status=1";
			//Discount Value
			$totdiff = $current_price - $our_price;
			$percent = $totdiff * 100;
			$percentsave = (empty($current_price) || $current_price == 0)?0:$percent/$current_price;
			//Getting Record Count
			$sellsqlinfo = $wpdb->get_var($sellsql);
			//Coupon Expire date
			$date = get_post_meta($post->ID,'coupon_end_date_time',true);
			if($date != ""){
				$tardate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_end_date_time',true));
				$tardate1= date("F d, Y",get_post_meta($post->ID,'coupon_end_date_time',true));
			}
			$stdate= date("F d, Y H:i:s",get_post_meta($post->ID,'coupon_start_date_time',true));
			
			if(get_post_meta($post->ID,'enddate',true) != '0'){
			if(get_post_meta($post->ID,'coupon_end_date_time',true) != "") {
				
				$endtime = get_post_meta($post->ID,'coupon_end_date_time',true);
				$expired_date = (time() >= $endtime)?1:0;
				
				if($expired_date && get_post_meta($post->ID,'enddate',true) != '0' || (get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo)) {
					if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
						update_post_meta($post->ID,'is_expired','1');
					}
				}
			} else {
				if(get_post_meta($post->ID,'enddate',true) != '0' || (get_post_meta($post->ID,'no_of_coupon',true)==$sellsqlinfo)) {
					if(get_post_meta($post->ID,'is_expired',true)== '0' || get_post_meta($post->ID,'is_expired',true)== '')	{
						update_post_meta($post->ID,'is_expired','1');
					}
				}
			} }
			$geo_longitude  = get_post_meta($post->ID,'geo_longitude',true);
			$geo_latitude  = get_post_meta($post->ID,'geo_latitude',true);
			$shhiping_address  = get_post_meta($post->ID,'shhiping_address',true);
			$coupon_type = get_post_meta($post->ID,'coupon_type',true);
			$no_of_coupon = get_post_meta($post->ID,'no_of_coupon',true); ?>
<?php if($sellsqlinfo == 0 ) { 
			$enddate = explode(" ",$tardate); 
			$curdate = explode(" ",date("F d, Y H:i:s"));
			$enddate= str_replace(",","",$enddate[1]);
			$curdate =  str_replace(",","",$curdate[1]);
			$startdate = explode(" ",$stdate);
			$strdate = str_replace(","," ",$startdate[1]);
			$curtime = $enddate - $curdate;
			$totaltime =  ($enddate - $strdate);
			$nowremail = $curdate - $strdate;
?>
            <input type="hidden" value="<?php echo $nowremail ; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
            <input type="hidden" value="<?php  echo ($enddate - $strdate) ; ?>" name="noofcoupon1" id="noofcoupon1"/>
<?php } else {  ?>
              <input type="hidden" value="<?php echo $sellsqlinfo; ?>" name="sellsqlinfo1" id="sellsqlinfo1"/>
              <input type="hidden" value="<?php echo $no_of_coupon; ?>" name="noofcoupon1" id="noofcoupon1"/>
<?php } ?>

<meta property="og:title" content="<?php echo $post->post_title; ?>" />
<meta property="og:description" content="<?php $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", strip_tags($post->post_content)); echo $content; ?>" />
<!--<meta property="og:image" content="thumbnail_image" />-->
            
           <div class="cf" id="bd"> 
            <div id="deals_content">
  				<div id="deal-intro" class="cf">
    				<h1><span clas="deal-today-link">Current Offer:</span> <?php echo $post->post_title; ?><?php if(file_exists(DDB_PUGIN_PATH.'skins/'.$theme.'/buy_now.png')):?><img src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/buy_now.png" style="width:70px;height:70px;float:right" alt="" /><?php endif;?></h1>
    
        <div class="main">
      <div class="deal-buy">
        <div class="deal-price-tag"></div>
        
        <!--condition for offer buy link -->       
        <p class="deal-price"><strong><?php echo get_post_currency_sym($post->ID);?><?php echo $our_price?></strong><span>        
        
        <?php 		if(get_post_meta($post->ID,'coupon_type',true) == 1) {?>
						<a href="<?php echo get_post_meta($post->ID,'coupon_link',true); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy_deal" target="_blank">
		<?php 		} else { ?>
						<a href="#" title="<?php echo BUY_NOW;?>" class="btn_buy_deal contact">
		<?php 		} ?><img src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/button-deal-buy.png" alt="" /></a>
        
        </span></p>
      </div>
      <div class="deal-discount">
        <div style="text-align:center"> <span style="font-weight:400">Original Price</span><br />
          <span style="font-size:16px"><?php echo get_post_currency_sym($post->ID);?><?php echo $current_price?></span> </div>
        <div style="text-align:center;padding-top:5px"> <span style="font-weight:400">Discount<br />
          </span> <span style="font-size:16px"><?php echo @number_format($percentsave,2);?>%</span> </div>
        <div style="text-align:center;padding-top:5px"> <span style="font-weight:400">You save<br />
          </span> <span style="font-size:16px"><?php echo get_post_currency_sym($post->ID);?><?php echo $totdiff;?>
          
          </span> </div>
      </div>
       <?php if(!empty($tardate)){?>    
      <div class="deal-box deal-status" id="deal-status">
        <p class="deal-buy-tip-top">Time Left to Buy</p>
        <img src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/bg-deal-open.gif" style="float: left;padding-right: 10px;" />
        <div style="text-align:center">
          <div id="timer"></div>
        </div>
        <br />
      </div>
 
<script type="text/javascript">	
	var time = new Date("<?php echo $tardate;?>");
	
	var d = new Date()
	var gmtHours = -d.getTimezoneOffset()/60;
	
	$(document).ready(function(){$('#timer').countdown({until: $.countdown.UTCDate(gmtHours, time), compact:true, layout: '<div style="font-size:20px;padding-bottom:10px;font-weight:bold">{dn} Days Left</div><div style="font-size:22px;font-weight:bold">{hn}:{mn}:{sn}<br /></div><div style="padding-left:50px">remaining</div>'})});
</script>      
      <!-- Slider box showing  in below site only -->
<script>
		$(document).ready(function() {
			var bought = $('');
	    $("#progressbar").progressbar({ value:<?php echo empty($sellsqlinfo)?0:$sellsqlinfo; ?>});
});
</script>

     <!-- <div class="deal-box deal-status deal-status-open" id="deal-status">
        <div class = "deal-buy-tip-top"><?php echo empty($sellsqlinfo)?0:$sellsqlinfo; ?> Bought </div>
        <div style="text-align: left; padding: 0pt; margin-left: 0%;background:url(<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/tipping_point.gif) no-repeat scroll left center transparent">&nbsp;</div>
        <div style="margin-left: 1px; margin-top: 28px; position: absolute;text-align: left;"><b>0</b></div>
        <div id="progressbar"></div>
        <div style="text-align: right;margin-top:-5px;"><b>1</b></div>
        <div class = "deal-buy-tip-top" >1 more needed to get the deal</div>
      </div>-->
      
      <!-- End  Slider box showing --> 
      <?php }?>
    </div>
    
    <div class="side">
      <div class="deal-buy-cover-img" id="team_images"> <a href="<?php the_permalink(); ?>">
<?php			if(get_post_meta($post->ID,'file_name',true) != "") { ?>
					<img src="<?php echo get_post_meta($post->ID,'file_name',true);//echo DDBWP_thumbimage_filter(get_post_meta($post->ID,'file_name',true),'&amp;w=330&amp;h=250&amp;zc=1&amp;q=80');?>" alt="" width="330" height="250" />
<?php 			} else { ?>
					<img src="<?php echo DDB_IMAGE_URL."no-image.png";?>" alt=""  width="330" height="250" />
<?php 			} ?>
			</a> </div>
      	<div align="right">
        <?php DDBWP_share_links(get_permalink($post->ID),$post->post_title);?>
      </div>  
      <div class="digest"><br />
        <?php _e('Q. How do I redeem my purchase?<br />
        Q. How long do I have to redeem?<br />
        Q. What is the refund policy?');?><br />
        
      </div>
    </div>
  </div>
  <div id="deal-stuff" class="cf">
    <div class="clear box box-split">
      <div class="box-top"></div>
      <div class="box-content cf">
        <div class="main">
          <h2 id="detail"><?php _e('About This Offer')?>:</h2>
          <div class="blk detail"><?php echo "".strip_tags($post->post_content)."";  ?><br />
          </div>          
        </div>
        <div class="side">
          <div id="side-business"> <br />
             <?php if(!empty($owner_name)){?>
            <h4><?php _e('Redeem At')?>:</h4>
            <?php echo $owner_name;?><br />
            <?php echo empty($coupon_website)?'':'Redeem Online: '.$coupon_website.'<br />'; ?>
            <?php }?>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="box-bottom"></div>
    </div>
  </div>
</div>
<?php include"deals_sidebar.php";?>     
</div>         
<?php 	} else{
		//No Deals Found
		?>
        
       <?php 	
}
		}  // foreach loop BOF
	} // 1st IF Condition EOF
	else{
?><div style="float:left; margin-left:20px;"><img src="<?php echo DDB_PUGIN_URL."images/no_deal.jpg";?>" alt="" /></div>
<div style="float:right; margin-right:20px;">
	<?php include"deals_sidebar.php";?> 
</div>
<?php 
}
/* Home Page Deal Display EOF */ ?>