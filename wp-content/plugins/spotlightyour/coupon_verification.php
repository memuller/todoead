<?php
if(!function_exists('get_option')){
		$file = dirname(__FILE__);
		$file = substr($file,0,stripos($file, "wp-content"));
		require($file . "/wp-load.php");
	}
	$arr =  get_role( 'contributor' );;
	//$arr = unserialize($str);
	echo "<pre>"; print_r($arr); die;
	
?>
<div id="content" class="coupons-box clear mainwide">
  <div class="box clear">
    <div class="box-top"></div>
    <div class="box-content">
      <div class="head">
        <h2>Coupon Verification</h2>
      </div>
      <div class="sect">
        <form id="CouponVerifyIndexForm" method="post" action="/coupons/verify_index" accept-charset="utf-8">
          <div style="display:none;">
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="data[_Token][key]" value="d742ae966e93246c33fde730f70c129988a1c185" id="Token440674009">
          </div>
          <div class="field" style="float:left">
            <label>Vouchre</label>
            <input name="vouchre" type="text" style="width: 130px">
          </div>
          <div class="field">
            <label>Coupon</label>
            <input type="text" name="coupon" value="" style="width: 130px">
          </div>
          <div class="act">
            <div class="submit">
              <input class="formbutton" type="submit" value="Check">
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="box-bottom"></div>
  </div>
</div>
