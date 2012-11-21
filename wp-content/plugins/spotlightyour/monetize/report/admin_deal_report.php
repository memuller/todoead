<?php 
global $wpdb,$transection_db_table_name;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";
$user_db_table_name1 = $wpdb->prefix . "users";
if($wpdb->get_var("SHOW TABLES LIKE \"$user_db_table_name1\"") != $user_db_table_name1)	{
	$tbl_users = $wpdb->get_var("SHOW TABLES LIKE \"%users\"");
	$user_db_table_name = $tbl_users;
} else{
	$user_db_table_name = $user_db_table_name1;
}
?>
<h3>Deal Report</h3>
<div class="divright"><a href="<?php echo DDB_PUGIN_URL.'/monetize/report/export_dealreport.php';?>" title="Export To CSV" class="i_export">Export To CSV</a></div>
  <form method="post" action="<?php echo site_url('/wp-admin/admin.php?page=report#option_deal_report');?>" name="ordersearch_frm">
        <table cellspacing="1" cellpadding="4" border="1" width="100%" style="padding:5px;">
            <tr>
				<td valign="top" style="width:100px;"><strong><?php _e('Deal Title','ddb_wp'); ?> :</strong></td>
				<td valign="top" style="width:210px;"><select name="deal_id" style="width:200px;"><option value="">Select Deal</option><?php echo deal_cmb($_REQUEST['deal_id']);?></select></td>
				<td valign="top" >&nbsp;&nbsp;<input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action" onclick="chkfrm();" /></td>
			</tr>
    </table>
    </form><br />
  <?php

$recordsperpage = 30;
$trans_table = $wpdb->prefix."deal_transaction";
$post_table = $wpdb->prefix."posts";
$targetpage = site_url("/wp-admin/admin.php?page=report");
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$recordsperpage;
$endlimit = $strtlimit+$recordsperpage;
$orderCount = 0;
//----------------------------------------------------
$ordersql_select = "select t.*,p.ID ";
$ordersql_from= " from $trans_table t,$post_table p ";
$ordersql_conditions= " where p.ID = t.post_id and t.status = '1'";
if($_REQUEST['deal_id'] != '')
{
	$id = $_REQUEST['deal_id'];
	$ordersql_conditions .= " and t.post_id = $id";
}
$ordersql_conditions .= " group by p.ID";
$ordersql_limit = " limit $strtlimit,$recordsperpage";
$priceinfo_count = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions);
$priceinfo = $wpdb->get_results($ordersql_select.$ordersql_from.$ordersql_conditions.$ordersql_limit);
$total_pages = count($priceinfo_count);
if($total_pages > 0) { 
 ?>
<table style="100%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
		<th width="30" align="left"><?php _e('ID','ddb_wp'); ?></th>
		<th align="left"><?php _e('Title','ddb_wp'); ?></th>
		<th align="left" ><?php _e('Total Transaction','ddb_wp'); ?></th>
		<th align="left"><?php _e('Status','ddb_wp'); ?></th>
		<th align="left"><?php _e('Action','ddb_wp'); ?></th>
	</tr>
	<?php foreach($priceinfo as $priceinfoObj)
	{
	$status = ifetch_status(get_post_meta($priceinfoObj->ID,'status',true),get_post_meta($priceinfoObj->ID,'is_expired',true));
	if($status == 'Pending'){
				$status_dis = "<span class='color_pending'>Pending</span>";
			} else if($status == 'Expired') {
				$status_dis = "<span class='color_expire'>Expired</span>";
			} else if($status == 'Accepted') {
				$status_dis = "<span class='color_active'>Accepted</span>";
			} else if($status == 'Active') {
				$status_dis = "<span class='color_active'>Active</span>";
			}else if($status == 'Rejected') {
				$status_dis = "<span class='color_reject'><strong>Rejected</strong></span>";
			} else {
				$status_dis = "<span class='color_terminate'><strong>Terminated</strong></span>";
			}
?>
    <tr>
      <td><?php echo $priceinfoObj->ID;?></td>
      <td><?php echo $priceinfoObj->post_title;?></td>
      <td><?php echo deal_transaction($priceinfoObj->ID);?></td>
      <td><?php echo $status_dis;?></td>
      <td><a href="javascript:void(0);dealshowdetail('<?php echo $priceinfoObj->ID;?>');"><?php _e('Details','ddb_wp');?></a> | <a href="<?php echo DDB_PUGIN_URL.'/monetize/report/export_dealreport.php?deal_id='.$priceinfoObj->ID;?>"><?php _e('Export','ddb_wp');?></a></td>
    </tr>
	<tr id="dealdetail_<?php echo $priceinfoObj->ID;?>" style="display:none;">
		<td colspan="5">
			<?php $trans_table = $wpdb->prefix."deal_transaction";
				
				$deal_cnt = mysql_query("select * from $trans_table where post_id = '".$priceinfoObj->ID."' and status = '1'");
				while($deal_cnt_res = mysql_fetch_array($deal_cnt)){
				?>
				<table style="background-color:#eee;margin-bottom:10px;" width="100%">
				<tr>
					<td><?php _e('Title','ddb_wp')?> : <strong><?php echo $deal_cnt_res['post_title'];?></strong></td>
					<td><?php _e('Deal Coupon','ddb_wp')?> : <strong><?php echo $deal_cnt_res['deal_coupon'];?></strong></td>
					<td><?php _e('Pay Date','ddb_wp')?> : <strong><?php echo date('d/m/Y',strtotime($deal_cnt_res['payment_date']));?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Billing name','ddb_wp')?> : <strong><?php echo $deal_cnt_res['billing_name'];?></strong></td>
					<td colspan="2"><?php _e('Billing address','ddb_wp')?> : <strong><?php echo $deal_cnt_res['billing_add'];?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Shipping name','ddb_wp')?> : <strong><?php echo $deal_cnt_res['shipping_name'];?></strong></td>
					<td colspan="2"><?php _e('Shpping address','ddb_wp')?> : <strong><?php echo $deal_cnt_res['shipping_add'];?></strong></td>
				</tr>
				<tr>
					<td><?php _e('Amount','ddb_wp')?>(<?php echo get_currency_sym();?>) : <strong><?php echo number_format($deal_cnt_res['payable_amt'],2);?></strong></td>
					<td  colspan="2"><?php _e('Pay Method','ddb_wp')?> : <strong><?php echo $deal_cnt_res['payment_method'];?></strong></td>
				</tr>
			</table>
			<?php } ?>
		</td>
      </tr>	
	<?php
	}

?>
    <tr><td colspan="5" align="center">
            <?php
			if($total_pages>$recordsperpage)
			{
			echo get_pagination($targetpage,$total_pages,$recordsperpage,$pagination,'#option_deal_report');
			}?>
            </td></tr>
  </thead>
</table>
 <?php
}else {
?>
<strong><?php _e('No Transaction Available'); ?></strong>
      <?php
}

?>
<script>
function dealshowdetail(custom_id)
{
	if(document.getElementById('dealdetail_'+custom_id).style.display=='none')
	{
		document.getElementById('dealdetail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('dealdetail_'+custom_id).style.display='none';	
	}
}</script>