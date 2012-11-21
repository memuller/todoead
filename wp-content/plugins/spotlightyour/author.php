<?php 
include_once( 'wp-load.php' );
include_once(ABSPATH.'wp-includes/registration.php');
$_GET['author'] =isset($_GET['at'])?$_GET['at']:1;
?>
<?php get_header(); ?>
<script type="text/javascript" src="<?php echo DDB_PUGIN_URL; ?>/library/js/tabber.js"></script>
<script type="text/javascript" src="<?php echo DDB_PUGIN_URL; ?>/js/timer.js"></script>
<script type="text/javascript">
function viewtransaction(cuid,did)
{
	location.href= "?dwtype=author&at="+cuid+"&transid="+did;
}
function showtransdetail(details_id)
{ 
	if(document.getElementById('transaction_'+details_id).style.display=='none')	{
		document.getElementById('transaction_'+details_id).style.display='';
	}else	{
		document.getElementById('transaction_'+details_id).style.display='none';	
	}
}

	function a()
	{
		return false;
	}

	function buydeal(oid,did)
	{
	location.href= "?dwtype="+oid+"&did="+did;
	}
	
	function delete_deal(dealid)
	{    
	  if (dealid=="")
	  {
	  document.getElementById("deletedeal").innerHTML="";
	  return;
	  }
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("deletedeal").innerHTML=xmlhttp.responseText;
		
		}
	  }
	    url = "<?php echo DDB_PUGIN_URL; ?>/monetize/deal/ajax_delete_deal.php?delete_id="+dealid+"&myid="+dealid
	 	xmlhttp.open("GET",url,true);
	  	xmlhttp.send();
	}

</script>
<script type="text/javascript">document.write('<style type="text/css">.tabber { display: none; }<\/style>');</script>
<?php
global $current_user; extract($_GET);
global $wpdb,$deal_db_table_name;	
$postmeta_db_table_name = $wpdb->prefix . "postmeta";
$post_db_table_name = $wpdb->prefix . "posts";
$transaction_table = $wpdb->prefix."deal_transaction";

$current_user;
if(!function_exists('get_userdata')){
	require_once(ABSPATH."wp-includes/pluggable.php");	
}
if(isset($_GET['author_name'])) :    
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
$user_db_table_name = get_user_table();
$destination_path = site_url().'/wp-content/uploads/';

if($curauth->ID == $current_user->ID) {
	$title_name = WELCOME." ".$curauth->display_name;
	$user_displayname = $curauth->display_name ;
	$dashboard_display = '<a href="'.DDBWP_get_author_posts_url($current_user->ID).'" class="back_link" >'.BACK_TO_DASHBOARD.'</a>';
} elseif($curauth->ID != $current_user->ID ){
	$title_name	 = $curauth->display_name.DEAL_S;
	$user_displayname = $curauth->display_name;
} else {
	// donothing
} 

if ( get_option('ddbwpthemes_breadcrumbs' )) {  
$sep_array = get_option('yoast_breadcrumbs');
$sep = $sep_array['sep'];
?>

<div class="breadcrumb clearfix">
  <div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php echo HOME;?></a> <?php echo $sep; ?> <?php echo $user_displayname; ?></div>
</div>
<?php } ?>
<!-- Content  2 column - left Sidebar  -->
<div  class="<?php DDBWP_content_css();?>" >
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('page_content_above')){ } else {  }?>
  <div class="content-title">
    <h1><?php echo $title_name ; ?> </h1>
  </div>
  <!-- BOF Author Detail -->
  <?php if(!isset($_REQUEST['transid'])) { ?>
  <div class="details_main">
    <div class="detail_photo">
      <?php 		if(get_user_meta($curauth->ID,'user_photo',true) != "") { ?>
      <img src="<?php echo DDBWP_thumbimage_filter($destination_path.get_user_meta($curauth->ID,'user_photo',true),'&amp;w=145&amp;h=160&amp;zc=1&amp;q=80');?>" alt="" />
      <?php 	} else { ?>
      <img src="<?php echo DDBWP_thumbimage_filter(DDB_PUGIN_URL."/images/no-image.png",'&amp;w=145&amp;h=160&amp;zc=1&amp;q=80');?>" alt="" />
      <?php 	} ?>
    </div>
    <div class="detail_content">
      <h3><?php echo $user_displayname;	?></h3>
      <p class="detail_links">
        <?php if(get_user_meta($curauth->ID,'user_website',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_website',true);?>" target="_blank"><?php echo VISIT_WEBSITE;?></a>
        <?php } ?>
        <?php if(get_user_meta($curauth->ID,'user_twitter',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_twitter',true);?>" target="_blank"><?php echo TWITTER;?></a>
        <?php } ?>
        <?php if(get_user_meta($curauth->ID,'user_facebook',true) != "" ) {?>
        <a href="<?php echo get_user_meta($curauth->ID,'user_facebook',true);?>" target="_blank"><?php echo FACEBOOK;?></a>
        <?php } ?>
      </p>
      <ul class="user_detail">
        <?php if($curauth->ID == $current_user->ID) {?>
        <li><span><?php echo DEAL_PURCHASE;?> : </span><?php echo deal_salecount_post($curauth->ID);?></li>
        <?php }?>
        <li><span><?php echo DEAL_PROVIDED;?> : </span><?php echo deal_count_post($curauth->ID);?></li>
        <li><?php echo get_user_meta($curauth->ID,'user_about',true);?></li>
      </ul>
    </div>
  </div>
  <?php } ?>
  <!-- EOF Author Detail -->
  <?php   
  
$UID=$curauth->ID;
	$email_id = $curauth->user_email;
	$username  = $curauth->user_login;
	$targetpage = DDBWP_get_author_posts_url($curauth->ID); //die('I am here');
	$total_deals = mysql_query("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = 'seller' and p.post_status = 'publish' ");
	$total_pages = mysql_num_rows($total_deals);
	$recordsperpage = 5;
	$pagination = $_REQUEST['pagination'];
	if($pagination == '') {
		$pagination = 1;
	}
	$strtlimit = ($pagination-1)*$recordsperpage;
	$endlimit = $strtlimit+$recordsperpage;
	$dealcnt_sql = $wpdb->get_results("select p.* from $post_db_table_name p where post_author = '".$curauth->ID."' and p.post_type = 'seller' and p.post_status = 'publish' limit $strtlimit,$recordsperpage ");
if($curauth->ID == $current_user->ID && !isset($_REQUEST['transid'])) {
//----------------------------------------------------		
?>
  <div id="deletedeal"></div>
  <div class="tabber">
    <div class="tabbertab">
      <?php include_once(DDB_PUGIN_PATH.'/monetize/author_detail/deal_provided.php');?>
    </div>
    <div class="tabbertab">
      <?php include_once(DDB_PUGIN_PATH.'/monetize/author_detail/deal_purchased.php');?>
    </div>
  </div>
  <?php  } 
 // Transaction Detail BOF
if(isset($_REQUEST['transid']) ||($_REQUEST['transid']) != "" && $curauth->ID == $current_user->ID) {
	include_once(DDB_PUGIN_PATH.'/monetize/author_detail/transaction_detail.php');
}   // Transaction Detail EOF
/* Author Detail BOF */
if($curauth->ID != $current_user->ID && !isset($_REQUEST['transid'])) {
	include_once(DDB_PUGIN_PATH.'/monetize/author_detail/author_detail.php');
} 
/* Author Detail EOF */
if (function_exists('dynamic_sidebar') && dynamic_sidebar('page_content_below')){ } else { }?>
</div>
<!-- /Content -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
