<?php 
/*****************************************
	Merchant Signup Page
*****************************************/
$message = '';
//Form Submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//echo '<pre>';	print_r($_POST);	die;
	
	if(isset($_POST['user_signup'])){
		
		$subscribe_me = isset($_POST['subscribe_me'])?1:0;	
		$seller_category = $_POST['seller_category'];
		$_POST = $_POST['data']['User'];
		
		$user_id = username_exists( $user_name );
		
		if ( !$user_id ) {			
			$userdata = array(
							'user_login'=>$_POST['username'],
							'user_pass'=>$_POST['password'],
							'user_email'=>$_POST['email'],
							'first_name'=>$_POST['f_name'],
							'last_name'=>$_POST['l_name'],
							
							
							);
			$user_id =  wp_insert_user( $userdata );
			//Adding Users Other details
			$usr_arr['address'] = $_POST['address'];
			$usr_arr['city_name'] = $_POST['city_name'];
			$usr_arr['state'] = $_POST['state'];
			$usr_arr['country'] = $_POST['country'];
			$usr_arr['zipcode'] = $_POST['zipcode'];
			$usr_arr['mobile'] = $_POST['mobile'];
									
			add_user_meta( $user_id, 'user_address', serialize($usr_arr));
								
			add_user_meta( $user_id, 'subscribe_me', $subscribe_me );
			add_user_meta( $user_id, 'seller_category', $seller_category);
						
			if($user_id)
				$message = __('Your account created');
			else	
				$message = __('Some error occured');
		} else {
			
			$message = __('User already exists.');
			
		}
	}
}

$args = array(	 //'show_option_all' => "Show All Categories",
				 'taxonomy'  => CUSTOM_CATEGORY_TYPE1,
				 'name'      => CUSTOM_CATEGORY_TYPE1
			 );

		
ob_start();
?>

<div id="deals_content" class="signup-box">
  <div class="box">
    <div class="box-top"><?php echo empty($message)?'':'<p align="center" style="color:#060">'.$message.'</p>';?></div>
    <div class="box-content">
      <div class="sect">
        <form id="signup-user-form" class="validator" enctype="multipart/form-data" method="post" action="<?php echo get_permalink()?>" accept-charset="utf-8">
          <input type="hidden" name="user_signup" value="1">
          <div class="field email">
            <label for="signup-email-address">E-mail <span class="required">*</span></label>
            <input name="data[User][email]" type="text" size="30" id="signup-email-address" class="f-input" maxlength="128">
            <span id="email_test"></span> </div>
         
                   
          <!-- NP module  -->
          
          <div class="field username">
            <label for="signup-username">Username <span class="required">*</span></label>
            <input name="data[User][username]" type="text" size="30" id="signup-username" class="f-input" maxlength="32">
          </div>
          <div class="field password">
            <label for="signup-password">Password <span class="required">*</span></label>
            <input type="password" name="data[User][password]" size="30" id="signup-password" class="f-input">
            <span class="inputtip">Password length should be 5 through 11</span> </div>
          <div class="field password">
            <label for="signup-password-confirm">Confirm Password <span class="required">*</span></label>
            <input type="password" name="data[User][password2]" size="30" id="signup-password-confirm" class="f-input">
          </div>
          <div class="field">
            <label for="signup-mobile">First Name <span class="required">*</span></label>
            <input name="data[User][f_name]" type="text" size="30" id="signup-username" class="f-input" maxlength="32">
          </div>
          <div class="field">
            <label for="signup-mobile">Last Name <span class="required">*</span></label>
            <input name="data[User][l_name]" type="text" size="30" id="signup-username" class="f-input" maxlength="32">
          </div>
          <div class="field city">
            <label id="enter-address-city-label" for="signup-city">Address</label>
            <textarea name="data[User][address]" style="width:325px;height:100px" id="UserAddress"></textarea>
          </div>
          <div class="field">
            <label for="signup-username">City</label>
            <input name="data[User][city_name]" type="text" maxlength="50" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-username">State/Province</label>
            <input name="data[User][state]" type="text" maxlength="50" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-username">Country</label>
            <input name="data[User][country]" type="text" maxlength="50" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-mobile">Postal Code</label>
            <input name="data[User][zipcode]" type="text" maxlength="30" id="signup-username" class="number">
          </div>
          <div class="field">
            <label for="signup-mobile">Telephone</label>
            <input name="data[User][mobile]" type="text" size="30" id="signup-mobile" class="number" maxlength="16">
          </div>
          <div class="field">
            <label for="signup-mobile">Subscribe</label>
            <input type="checkbox" value="1" name="subscribe_me" checked="checked">
            &nbsp;&nbsp;
            <?php wp_dropdown_categories($args);?>
            &nbsp;&nbsp;<span style="font-size:12px">(Send me emails for new offers) </span> </div>
          <div class="act"> <br>
            <div class="submit">
              <input id="signup-submit" class="formbutton" type="submit" value="Sign Up">
            </div>
            <div style="display:none;">
              <input type="hidden" name="data[_Token][fields]" value="b8a7b0d7b644f727f52e0d73da2d02901f9c2741%3An%3A2%3A%7Bv%3A0%3Bf%3A16%3A%22Hfre.perngr_gvzr%22%3Bv%3A1%3Bf%3A15%3A%22Hfre.ybtva_gvzr%22%3B%7D" id="TokenFields1741862693">
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="box-bottom"></div>
  </div>
</div>
<?php     
	$output =ob_get_clean();
	$content = str_replace($register_identifier,$output,$content);	
?>
