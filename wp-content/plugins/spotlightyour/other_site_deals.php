<?php
$theme = get_option('ddbwpthemes_alt_stylesheet');

//Global Database
global $wpdb,$deal_db_table_name, $table_prefix ;	

define('DDB_OTHER_DEALS_TBL',$wpdb->prefix."otherdeals");
/* Mail To Friend EOF */
/* Home Page Deal Display BOF */

$destination_path = site_url().'/wp-content/uploads/';

$sql = "SELECT * FROM ".DDB_OTHER_DEALS_TBL." where end_time >= now() ORDER BY RAND() LIMIT 1";;

$recent_posts = $wpdb->get_row($sql, OBJECT); 

if(!empty($recent_posts)) { // 1st IF Condition BOF
	$deal = $recent_posts;
	
		
			global $home_deal_id;
			//Coupon Website
			$coupon_website= "http://www.icoupononline.com";
						
			//Offer Price
			$our_price= $deal->offer_price;
			//Real Price
			$current_price= $deal->market_price;;
			
			//Discount Value
			$totdiff = $current_price - $our_price;
			$percent = $totdiff * 100;
			$percentsave = $percent/$current_price;
			
			//Coupon Expire date
			$date = $deal->end_time;
			
			if($date != ""){
				$tardate= date("F d, Y H:i:s",strtotime($deal->end_time));
				$tardate1= date("F d, Y",strtotime($deal->end_time));
			}
			
			$stdate= date("F d, Y H:i:s",strtotime($deal->begin_time));
			
			if($deal->end_time != '0'){			
					
				
						$enddate = explode(" ",$tardate); 
						$curdate = explode(" ",date("F d, Y H:i:s"));
						$enddate= str_replace(",","",$enddate[1]);
						$curdate =  str_replace(",","",$curdate[1]);
						$startdate = explode(" ",$stdate);
						$strdate = str_replace(","," ",$startdate[1]);
						$curtime = $enddate - $curdate;
						$totaltime =  ($enddate - $strdate);
						$nowremail = $curdate - $strdate; ?>
           
           <div class="cf" id="bd"> 
            <div id="deals_content">
  				<div id="deal-intro" class="cf">
    				<h1><span clas="deal-today-link">Current Offer:</span> <?php echo $deal->title; ?><?php if(file_exists(DDB_PUGIN_PATH.'skins/'.$theme.'/buy_now.png')):?><img src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/buy_now.png" style="width:70px;height:70px;float:right" alt="" /><?php endif;?></h1>
    
        <div class="main">
      <div class="deal-buy">
        <div class="deal-price-tag"></div>
        
        <!--condition for offer buy link -->
        
        <p class="deal-price"><strong><?php echo get_post_currency_sym($post->ID);?><?php echo $our_price?></strong><span>        
        <a href="<?php _e($deal->icoupon_checkout_url); ?>" title="<?php echo BUY_NOW;?>" class="btn_buy_deal">
		<img src="<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/button-deal-buy.png" alt="" /></a>
        
        </span></p>
      </div>
      <div class="deal-discount">
        <div style="text-align:center"> <span style="font-weight:400">Original Price</span><br />
          <span style="font-size:16px"><?php echo get_currency_sym();?><?php echo $current_price?></span> </div>
        <div style="text-align:center;padding-top:5px"> <span style="font-weight:400">Discount<br />
          </span> <span style="font-size:16px"><?php echo @number_format($percentsave,2);?>%</span> </div>
        <div style="text-align:center;padding-top:5px"> <span style="font-weight:400">You save<br />
          </span> <span style="font-size:16px"><?php echo get_currency_sym();?><?php echo $totdiff;?>
          
          </span> </div>
      </div>
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
	    $("#progressbar").progressbar({ value:0});
});
</script>
      <div class="deal-box deal-status deal-status-open" id="deal-status">
        <div class = "deal-buy-tip-top">0 Bought </div>
        <div style="text-align: left; padding: 0pt; margin-left: 0%;background:url(<?php echo DDB_PUGIN_URL.'skins/'.$theme;?>/tipping_point.gif) no-repeat scroll left center transparent">&nbsp;</div>
        <div style="margin-left: 1px; margin-top: 28px; position: absolute;text-align: left;"><b>0</b></div>
        <div id="progressbar"></div>
        <div style="text-align: right;margin-top:-5px;"><b>1</b></div>
        <div class = "deal-buy-tip-top" >1 more needed to get the deal</div>
      </div>
      
      <!-- End  Slider box showing --> 
      
    </div>
    <div class="side">
      <div class="deal-buy-cover-img" id="team_images"> <a href="<?php echo $deal->icoupon_checkout_url; ?>">

					<img src="<?php echo DDBWP_thumbimage_filter($deal->image,'&amp;w=330&amp;h=250&amp;zc=1&amp;q=80');?>" alt="" />
			</a> </div>
      	<div align="right">
        <span class='st_facebook_large' displayText='Facebook'></span>
        <span class='st_twitter_large' displayText='Tweet'></span>
        <span class='st_linkedin_large' displayText='LinkedIn'></span>
        <span class='st_email_large' displayText='Email'></span>
        <span class='st_sharethis_large' displayText='ShareThis'></span>
      </div>  
      <div class="digest"><br />
        <?php _e($deal->summary);?><br />        
      </div>
    </div>
  </div>
  <div id="deal-stuff" class="cf">
    <div class="clear box box-split">
      <div class="box-top"></div>
      <div class="box-content cf">
        <div class="main">
          <h2 id="detail"><?php _e('About This Offer')?>:</h2>
          <div class="blk detail"><?php echo "".$deal->detail."";  ?><br />
          <h2>Please Note:</h2>
          <?php echo "".$deal->notice."";  ?><br />
          </div>          
        </div>
        <div class="side">
          <div id="side-business"> <br />
            <br />            
            <h4><?php _e('Redeem At')?>:</h4>
            <?php echo $deal->redeem_at;?><br />            
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <div class="box-bottom"></div>
    </div>
  </div>
</div>
<?php include"other_deals_sidebar.php";?>     
</div>         
<?php 	} 
}?>	