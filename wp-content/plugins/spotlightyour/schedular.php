<?php  
ini_set("display_errors","On"); 
set_time_limit(0);

	date_default_timezone_set('America/Los_Angeles');
	
	if(!function_exists('wp_upload_dir')){
		$file = dirname(__FILE__);
		$file = substr($file,0,stripos($file, "wp-content"));
		require($file . "/wp-load.php");
		
		getICouponDeals();
	}
	
if(!function_exists('clearImgCache'))	{
	function clearImgCache(){
		$files = glob(dirname(__FILE__).'/cache/*'); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file))
			unlink($file); // delete file
		}	
	}
}

if(!function_exists('getICouponDeals'))	{
function getICouponDeals() {
		
		global $table_prefix,$wpdb, $user_ID;;
		
		$sql = "SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = 'icoupon_id'";			
		//$post_id = $wpdb->get_var($sql);
		$postids=$wpdb->get_col($sql);
		if ($postids) 
		{					
			$post_ids = implode(',',$postids);
			$sql = "DELETE FROM $wpdb->postmeta WHERE `post_id` IN (".$post_ids.")";
			$wpdb->query($sql);				
			$sql = "DELETE FROM $wpdb->posts WHERE ID IN (".$post_ids.")"; 			
			$wpdb->query($sql);	
			
		}
					
		
		$dirinfo = wp_upload_dir();
		$uploadfolder = $dirinfo['path']."/";
		$uploadurl = $dirinfo['url']."/";
		$xml = new SimpleXMLElement(file_get_contents("http://www.icoupononline.com/rss_all_ddb.xml"), LIBXML_NOCDATA);
		$deals = $xml->channel->item;
		
		if(function_exists('mailMeLog')){
		 	$message1 = 'Scrapper started at '.date("d M Y H:i:s A").'and found '.sizeof($deals)." deals. ";
			mailMeLog($message1);
		}
		foreach($deals as $deal) {
			//echo "<pre>";			print_r($deal);			echo "</pre>"; die;
			
			$offer = array();
			//$offer['id'] = null;
			
			$offer['min_number'] = 1;
			$offer['max_number'] = 0;
			
			$offer['icoupon_id'] = intval($deal->deal_id);
			$offer['title'] = htmlspecialchars_decode(strval($deal->title));
			$offer['title'] = empty($offer['title'])?$deal->title:$offer['title'];
			
			if(empty($offer['title'])) continue;
			
			$offer['market_price'] = floatval($deal->value);
			$offer['offer_price'] = floatval($deal->price);
			//edited 
			$ic_b  = '' . $deal->deal_begin_utc;
			
			//$ic_b =  substr('' . $deal->deal_begin_utc,0,strlen($ic_b)-7);
			$ic_b =  substr('' . $deal->deal_begin_utc,0,strlen($ic_b)-7);
			//$timezone = get_option('timezone_string');
			$timezone = 0;
			//last conversion
			//$offer['begin_time'] = strtotime($ic_b)  + intval($timezone);
			//$ic_b = $ic_b + 28800;
			$offer['begin_time'] =  (strtotime($ic_b)  + intval($timezone)) + 28800;
			$offer['begin_time'] = date("Y-m-d H:i:s", $offer['begin_time']);
			
			
			$ic_b  = '' . $deal->deal_end_utc;
			$ic_b =  substr('' .$deal->deal_end_utc,0,strlen($ic_b)-7);
			//last conversion
			//$offer['end_time'] = strtotime($ic_b) + intval($timezone);
			//$ic_b = $ic_b + 28800;
			$offer['end_time'] = (strtotime($ic_b) + intval($timezone)) + 28800;
			$offer['end_time'] = date("Y-m-d H:i:s",$offer['end_time']);
			//edited 
			
		//	$offer['begin_time'] = strtotime(strval($deal->deal_begin_utc)) + intval($timezone);
		//	$offer['end_time'] = strtotime(strval($deal->deal_end_utc)) + intval($timezone);
		
			$offer['icoupon_checkout_url'] = strval($deal->checkout_url);
			$include_string = '';
			foreach($deal->includes_titles->includes_title as $include) {
				$include_string = $include_string . htmlspecialchars_decode(strval($include)) . '<br />';
			}
			$offer['summary'] = $include_string;
			$detail_string = '';
			foreach($deal->includes_explains->includes_explain as $explain) {
				$detail_string = $detail_string . htmlspecialchars_decode(strval($explain)) . '<br />';
			}
			$offer['detail'] = $detail_string;
			
			if(empty($offer['title']) || empty($offer['detail'])) continue;
			
			
			$offer['notice'] = htmlspecialchars_decode(strval($deal->terms));
			$redeem_at = $deal->store . '<br />';
			foreach($deal->locations->location as $location) {
				$redeem_at = $redeem_at . htmlspecialchars_decode(strval($location)) . '<br />';
			}
			$offer['redeem_at'] = htmlspecialchars_decode($redeem_at);
			if(htmlspecialchars_decode(strval($deal->city)) == 'National Deal' ) {
				$deal->city = 'All';
			}
			$new_city = array();
			$times = 0;
			//edited, do not add cities in systems table from icoupon rss feeds
			/*if(!in_array(strtolower(htmlspecialchars_decode(strval($deal->city))), $cities)) {
				//edited, to prevent adding cities , if it is deleted by admin
				if(!in_array(strtolower(htmlspecialchars_decode(strval($deal->city))), $is_del_cities)){
					$new_city['id'] = null;
					$new_city['name'] = 'city';
					$new_city['value'] = ucfirst(htmlspecialchars_decode(strval($deal->city)));
					$new_city['city_ordering'] = count($cities);
					$this->System->save($new_city);
					$cities[] = strtolower(htmlspecialchars_decode(strval($deal->city)));
				}	
			}*/
			
			$offer['city'] = htmlspecialchars_decode(strval($deal->city));
			$offer['ad'] = 'images';
			$offer['currency'] = 'USD';
			//$offer['type'] = 'product';
			$offer['flv'] = '';
			//$offer['fare'] = 0.00;
			//$offer['per_number'] = 0;
			$offer['commission_type'] = 'no';
			$imagename = '';
			if(!empty($deal->img)){					
				$deal_img_url = htmlspecialchars_decode(strval($deal->img));
				$strpos = strrpos($deal_img_url,'/');
				$file_name = substr($deal_img_url,$strpos+1);
				//$file_name =  time().'_'.(end( explode("/", $deal_img_url)));
				
				
				
				list($img_name,$ext) = explode('.',$file_name);
				if(!empty($img_name) && !empty($ext)){					
					$file_name  = htmlspecialchars_decode(strval($file_name));
					$imagename = $uploadurl. $file_name;
					$copyto = $uploadfolder. $file_name;
					copy(htmlspecialchars_decode(strval($deal->img)), $copyto);
				}
			}
			$offer['image'] = $imagename;
			$offer['offer_type'] = 'icoupon';
			$arr = $offer;
			
			//$this->Offer->save($arr);
			if($arr['market_price'] == 0 || empty($arr['market_price']) || empty($arr['end_time'])){
				continue;
				//echo "<pre>"; print_r($arr); "</pre>";
			}
			
			if(timeDiff($arr['end_time'])) continue;
			
			################### Adding Deals in Post Type #############
				
				$user_ID = empty($user_ID)?1:$user_ID;
				
				
				$excerpt=substr($offer['detail'],0,260);
				if (preg_match('/^.{1,160}\b/s', $offer['detail'], $match))
				{
					$excerpt=$match[0];
				}
				
					
				
				$new_post = array(
								'post_title' => $offer['title'],
								'post_content' => $offer['detail'],
								'post_status' => 'publish',
								'post_date' => date('Y-m-d H:i:s'),
								'post_date_gmt' => date('Y-m-d H:i:s'),
								'post_excerpt'=>$excerpt, 
								'post_author' => $user_ID,
								'post_type' => 'seller',
								//'post_category' => array(0)
							);
				$post_id = wp_insert_post($new_post);	
				
				if(!empty($offer['city']))
					wp_set_object_terms($post_id , $offer['city'], 'seller_category', true ) ;
				
				$checkout_url = $arr['icoupon_checkout_url'];
				$affilate_id = get_option('ddbwpthemes_icoupon_aff');
				if(!empty($affilate_id))
					$checkout_url .= '&aff_id='.$affilate_id;
					
			  $add_meta_data = array(   'status'=>2, 
			  							'_edit_last'=>1, 										
										'owner_name'=> $arr['redeem_at'],
										'icoupon_id' => $arr['icoupon_id'],										
										'coupon_type'=>1,
										'min_purchases'=>1,										
										'coupon_link'=>	$checkout_url,
										'file_name'=>$arr['image'],
										'coupon_start_date_time'=>	strtotime($arr['begin_time']),
										'coupon_end_date_time'=> strtotime($arr['end_time']),
										'is_expired'=>0,
										'enddate'=>'0',
										'our_price'=>$arr['offer_price'],
										'current_price'=>$arr['market_price']
										);
				$coupon_website = preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $arr['redeem_at'], $match);
				$add_meta_data['owner_name'] = strip_tags($add_meta_data['owner_name']);
				$pattern = 'Redeem Online:,';  $pattern2 = 'http://';
				if(strstr($add_meta_data['owner_name'],$pattern)){						 
					$pos = strpos($add_meta_data['owner_name'],$pattern);
					$add_meta_data['coupon_website']= trim(substr($add_meta_data['owner_name'],$pos+strlen($pattern))); 
					$add_meta_data['owner_name']= trim(substr($add_meta_data['owner_name'],0,$pos-1)); 
						
				}elseif(strstr($add_meta_data['owner_name'],$pattern2)){
					
					$pos = strpos($add_meta_data['owner_name'],$pattern2);
					$add_meta_data['coupon_website']= trim(substr($add_meta_data['owner_name'],$pos+strlen($pattern2))); 
					$add_meta_data['owner_name']= trim(substr($add_meta_data['owner_name'],0,$pos-1)); 
				}
					
				foreach($add_meta_data as $k=>$v){
					update_post_meta($post_id, $k, $v);
				}
			//echo "<pre>"; print_r($add_meta_data); echo "</pre>";
			##########################################################
			
			//echo $wpdb->insert( $dealsite_table, $arr);
			$wpdb->show_errors();
			
	   }
	   
	   	update_option('ddbwpthemes_icoupon_status',"0");	
		update_option('ddbwpthemes_icoupon_nextcron',strtotime("+ 1 Day"));	
		clearImgCache();
	}//end function 
}

if(!function_exists('timeDiff')){
	function timeDiff($firstTime)
	{
		// convert to unix timestamps
		$firstTime=strtotime($firstTime);
		$lastTime=time();
		
		// perform subtraction to get the difference (in seconds) between times
		$timeDiff=$lastTime-$firstTime;
		
		// return the difference
		return $timeDiff>0?true:false;
	}	
}
?>