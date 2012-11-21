<?php
/******************************************************************
=======  PLEASE DO NOT CHANGE BELOW CODE  =====
You can add in below code but don't remove original code.
This code to include add post,edit and preview from front end.
This file is included in functions.php of theme root at very last php coding line.

You can call add post,edit and preview page by the link 
Add New Post : http://mydomain.com/?dwtype=buydeal  => echo site_url('/?dwtype=buydeal');
Payment New Post : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=dealpaynow');
Payment Cancel Return : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=cancel_return');
Payment Payment Success : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=payment_success');
Payment Success : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=payment_success');
Paypal Return : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=return');
Paypal Success : http://mydomain.com/?dwtype=register => echo site_url('/?dwtype=success');
********************************************************************/
define('DDBWP_BUY_DEAL_FOLDER',DDB_MODULES_FOLDER_PATH . "deal/");
define('DDBWP_BUY_DEAL_URI',DDB_PUGIN_URL . "monetize/deal/");

include_once(DDBWP_BUY_DEAL_FOLDER.'lang_deal.php'); // language file

////////filter to retrive the page HTML from the url.
add_filter('DDBWP_add_template_page_filter','DDBWP_add_template_buy_deal_page'); //filter to add pages like addpost,preveiw,delete and etc....
include_once(DDBWP_BUY_DEAL_FOLDER.'functions_deal.php'); // function file
include_once(DDBWP_BUY_DEAL_FOLDER.'deal_expire.php'); // function file

?>