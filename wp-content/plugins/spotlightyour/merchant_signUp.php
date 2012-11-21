<?php 
/*****************************************
	Merchant Signup Page
*****************************************/
$message = '';

//Form Submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//echo '<pre>';	print_r($_POST);	die;
	
	if(isset($_POST['merchant_signup'])){
		$_POST = $_POST['data']['User'];
		
		$subject = 'New Merchant Registered on '.get_bloginfo('name');
		
		$message = 'A new merchant has registered on '.get_bloginfo('name').'.  We recommend to contact this merchant to further discuss what type of deal offering they are interested in running on your site.  If their offer makes sense for your website, we encourage you to work with the merchant and run one of their deals.<br><br>';
		
		$message .= '<strong>Name:</strong> '.$_POST['name'].'<br>';
		$message .= '<strong>Email:</strong> '.$_POST['email'].'<br>';
		$message .= '<strong>Business Name:</strong> '.$_POST['business'].'<br>';
		$message .= '<strong>Business Address:</strong> '.$_POST['baddress'].'<br>';
		$message .= '<strong>City:</strong> '.$_POST['bcity'].'<br>';
		$message .= '<strong>State:</strong> '.$_POST['bstate'].'<br>';
		$message .= '<strong>Zip/Postal Code:</strong> '.$_POST['bzip'].'<br>';
		$message .= '<strong>Phone Number:</strong> '.$_POST['bnumber'].'<br>';
		$message .= '<strong>About Your Business:</strong> '.$_POST['abtbusiness'].'<br><br>';
		
		$message .= 'Thanks,<br>The Spotlight Team';
			
		add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
		//$headers = 'From: '.$_POST['name'].' <'.$_POST['email'].'>' . "\r\n";
		wp_mail(get_bloginfo('admin_email'), $subject, $message);
		
		$message = '<p align="center" style="color:#060">We have received your request. Thank you</p>';
	}
}

ob_start();?>
<div id="deals_content" class="signup-box">
  <div class="box">
    <div class="box-top"><?php echo $message;?></div>
    <div class="box-content">
    <p style="padding:0 20px;">Do you want to feature your product on our site? Just fill out this form to post your deal. To get more sales and more earnings, make the title and the description as exciting as possible. The stage is all yours.</p>
      <div class="sect">
        <form id="signup-user-form" class="validator" method="post" action="<?php echo get_permalink()?>" accept-charset="utf-8">
        <input type="hidden" name="merchant_signup" value="1"> 
          <div class="field email">
            <label for="signup-email-address">Your Name<span class="required">*</span></label>
            <input name="data[User][name]" type="text" size="30" id="signup-email-address" class="f-input">
            <span class="inputtip"></span> </div>
          <div class="field">
            <label id="enter-address-city-label" for="signup-city">Email<span class="required">*</span></label>
            <input name="data[User][email]" type="text" class="f-input" maxlength="128" id="UserEmail">
            <span class="inputtip"></span> </div>
          <div class="field">
            <label>Business Name</label>
            <input name="data[User][business]" type="text" size="30" id="signup-username" class="f-input">
          </div>
          <div class="field password">
            <label for="signup-password">Business Address</label>
            <input name="data[User][baddress]" type="text" size="30" id="signup-password" class="f-input">
          </div>
          <div class="field password">
            <label for="signup-password-confirm">City</label>
            <input name="data[User][bcity]" type="text" size="30" id="signup-password-confirm" class="f-input">
          </div>
          <div class="field">
            <label for="signup-mobile">State</label>
            <input name="data[User][bstate]" type="text" size="30" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-mobile">Zip/Postal Code</label>
            <input name="data[User][bzip]" type="text" size="30" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-username">Phone Number</label>
            <input name="data[User][bnumber]" type="text" maxlength="50" id="signup-username" class="f-input">
          </div>
          <div class="field">
            <label for="signup-username">About Your Business</label>
            <textarea name="data[User][abtbusiness]" id="signup-username" class="f-input"></textarea>
          </div>
          <div class="act"> <br>
            <div>
              <input id="signup-submit" class="formbutton" type="submit" value="Sign Up">
            </div>
            <div style="display:none;">
              <input type="hidden" name="data[_Token][fields]" value="801a902ae8f4f8dcb27665ccdb2cef58cd383704%3An%3A0%3A%7B%7D" id="TokenFields384971531">
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
	$content = str_replace($merchant_identifier,$output,$content);	
?>