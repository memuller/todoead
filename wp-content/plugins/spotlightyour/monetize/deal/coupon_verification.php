<?php 
global $upload_folder_path,$transection_db_table_name,$last_postid,$is_login;
global $wpdb;

if (!is_user_logged_in())
	wp_redirect(site_url()."?dwtype=login");

if($_SERVER['REQUEST_METHOD'] =='Post'){
	
}

get_header(); 
?>
<span class="singular">          
   	<h1 class="entry-title"><?php echo __('Coupon Verification','ddb_wp');?></h1>
   </span>
   
  <div id="deals_content" class="signup-box">
  <div class="box">
  	<div class="box-top"><?php echo $message;?></div>
    <div class="box-content">
      <div class="sect">

 <div class="content left">
        <div class="post-content">
        <form id="CouponVerifyIndexForm" method="post" action="" accept-charset="utf-8">
          
          <div class="field" style="float:left">
            <label><?php echo __('Voucher','ddb_wp');?></label>
            <input name="voucher" type="text" style="width: 130px">
          </div>
          <div class="field">
            <label><?php echo __('Coupon','ddb_wp');?></label>
            <input type="text" name="coupon" value="" style="width: 130px">
          </div>
          <div class="act">
            <div class="submit">
              <input class="formbutton" type="submit" value="<?php echo __('Check','ddb_wp');?>">
            </div>
          </div>
        </form>
      </div>
    </div> <!-- /Content -->
         </div>
     </div>
    <div class="box-bottom"></div>
  </div>
</div>   
<br />
<?php get_sidebar();
 get_footer();
?>