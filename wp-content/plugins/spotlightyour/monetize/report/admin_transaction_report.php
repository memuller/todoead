<?php global $wpdb,$transection_db_table_name;

$transrecordsperpage = 30;
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$transrecordsperpage;
$endlimit = $strtlimit+$transrecordsperpage;
//----------------------------------------------------
$transsql_select = "select t.* ";
$transsql_count = "select count(t.trans_id) ";
$transsql_from= " from $transection_db_table_name as t ";
$transsql_conditions= " where t.status=1 ";
if($_REQUEST['id'])
{
	$id = $_REQUEST['id'];
	$transsql_conditions .= " and t.post_id = $id";
}
if($_REQUEST['srch_orderno'])
{
	$srch_orderno = $_REQUEST['srch_orderno'];
	$transsql_conditions .= " and t.trans_id = $srch_orderno";
}
if($_REQUEST['srch_name'])
{
	$srch_name = $_REQUEST['srch_name'];
	$transsql_conditions .= " and (t.billing_name like '%$srch_name%' OR t.pay_email like '%$srch_name%')";
}
if($_REQUEST['srch_payment'])
{
	$srch_payment = $_REQUEST['srch_payment'];
	$transsql_conditions .= " and t.payment_method like \"$srch_payment\"";
}
if($_REQUEST['srch_coupon'])
{
	$srch_coupon = $_REQUEST['srch_coupon'];
	$transsql_conditions .= " and t.deal_coupon like '%$srch_coupon%'";
}

if($_REQUEST['srch_payid'])
{
	$srch_payid = $_REQUEST['srch_payid'];
	$transsql_conditions .= " and t.paypal_transection_id like '%$srch_payid%'";
}
$transsql_limit=" order by t.trans_id desc limit $strtlimit,$transrecordsperpage";

$_SESSION['qry_string'] = $transsql_select.$transsql_from.$transsql_conditions;
$transinfo_count = $wpdb->get_results($transsql_select.$transsql_from.$transsql_conditions);
$transinfo = $wpdb->get_results($transsql_select.$transsql_from.$transsql_conditions.$transsql_limit);
$trans_total_pages = count($transinfo_count);


?>
<h3>Transaction Report</h3>
<div class="divright"><a href="<?php echo DDB_PUGIN_URL.'/monetize/report/export_transaction.php';?>" title="Export To CSV" class="i_export">Export To CSV</a></div>
    <form method="post" action="<?php echo site_url('/wp-admin/admin.php?page=report#option_trans_report');?>" name="ordersearch_frm">
        <table cellspacing="1" cellpadding="4" border="1" width="100%" style="padding:5px;">
            <tr>
				<td valign="top"><strong><?php _e('Search by transaction ID','ddb_wp'); ?> :</strong></td>
				<td valign="top"><input type="text" value="" name="srch_orderno" id="srch_orderno" style="width:100px;" /><br /></td>
				<td valign="top"><strong><?php _e('Payment Type','ddb_wp'); ?> :</strong></td>
				<td valign="top">
				<?php
					$targetpage = site_url("/wp-admin/admin.php?page=report");
					$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
					$paymentinfo = $wpdb->get_results($paymentsql);
					if($paymentinfo)
					{
						foreach($paymentinfo as $paymentinfoObj)
						{
							$paymentInfo = unserialize($paymentinfoObj->option_value);
							$paymethodKeyarray[$paymentInfo['key']] = $paymentInfo['key'];
							ksort($paymethodKeyarray);
						}
					} ?>
					<select name="srch_payment" style="width:150px;">
						<option value=""> <?php _e('Select Payment Type','ddb_wp'); ?> </option>
						<?php foreach($paymethodKeyarray as $key=>$value) {
							if($value) { ?>
						<option value="<?php echo $value;?>" <?php if($value==$_REQUEST['srch_payment']){?> selected<?php }?>><?php echo $value;?></option>
						<?php }
						}?>
					</select></td>
			</tr>
			<tr>
				<td  valign="top"><strong><?php _e('Name/Email','ddb_wp'); ?> :</strong></td>
				<td valign="top"><input type="text" value="" name="srch_name" id="srch_name"  style="width:120px;" /><br /></td>
				<td  valign="top"><strong><?php _e('Deal Coupon','ddb_wp'); ?> :</strong></td>
				<td valign="top"> <input type="text" value="" name="srch_coupon" id="srch_coupon"  style="width:120px;" /><br /></td>
			</tr>
			<tr>			
				<td  valign="top"><strong><?php _e('Payment Transaction ID','ddb_wp'); ?> :</strong></td>
				<td valign="top" colspan="2"> <input type="text" value="" name="srch_payid" id="srch_payid"  style="width:200px;"/><br /></td>
				<td valign="top" >&nbsp;&nbsp;<input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action"  />&nbsp;<input type="reset" name="Default Reset" value="<?php _e('Reset'); ?>" onclick="window.location.href='<?php echo $targetpage;?>'" class="button-secondary action" /></td>
				
        </tr>
    </table>
    </form><br />
  <?php
if($trans_total_pages>0)
{ 

if($transinfo)
{ ?>
<table style="100%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
    <th width="20" align="left"><?php _e('ID','ddb_wp'); ?></th>
    <th align="left"><?php _e('Title','ddb_wp'); ?></th>
    <th align="left"><?php _e('Name','ddb_wp'); ?></th>
    <th align="left"><?php _e('Email','ddb_wp'); ?></th>
    <th align="left"><?php _e('Deal Coupon','ddb_wp'); ?></th>
    <th align="left">Action</th>
    </tr>
	<?php foreach($transinfo as $transinfoObj)
	{
?>
    <tr>
      <td><?php echo $transinfoObj->trans_id;?></td>
      <td><?php echo '<a href="'.site_url().'/wp-admin/admin.php?page=report&deal_id='.$transinfoObj->post_id.'#option_deal_report">'.$transinfoObj->post_title.'</a>';?></td>
      <td><?php echo $transinfoObj->billing_name;?></td>
      <td><?php echo $transinfoObj->pay_email;?></td>
      <td><?php echo $transinfoObj->deal_coupon;?></td>
      <td> <a href="javascript:void(0);reportshowdetail('<?php echo $transinfoObj->trans_id;?>');"><?php _e('Details','ddb_wp');?></a></td>
    </tr>
	<tr id="reprtdetail_<?php echo $transinfoObj->trans_id;?>" style="display:none;">
		<td colspan="6">
			<table style="background-color:#eee;" width="100%">
				<tr>
					<td><?php _e('Title','ddb_wp')?> : <strong><?php echo $transinfoObj->post_title;?></strong></td>
					<td><?php _e('Deal Coupon','ddb_wp')?> : <strong><?php echo $transinfoObj->deal_coupon;?></strong></td>
					<td><?php _e('Pay Date','ddb_wp')?> : <strong><?php echo date('d/m/Y',strtotime($transinfoObj->payment_date));?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Billing name','ddb_wp')?> : <strong><?php echo $transinfoObj->billing_name;?></strong></td>
					<td colspan="2"><?php _e('Billing address','ddb_wp')?> : <strong><?php echo $transinfoObj->billing_add;?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Shipping name','ddb_wp')?> : <strong><?php echo $transinfoObj->shipping_name;?></strong></td>
					<td colspan="2"><?php _e('Shpping address','ddb_wp')?> : <strong><?php echo $transinfoObj->shipping_add;?></strong></td>
				</tr>
				<tr>
					<td><?php _e('Amount','ddb_wp')?>(<?php echo get_currency_sym();?>) : <strong><?php echo number_format($transinfoObj->payable_amt,2);?></strong></td>
					<td  colspan="2"><?php _e('Pay Method','ddb_wp')?> : <strong><?php echo $transinfoObj->payment_method;?></strong></td>
				</tr>
			</table>
		</td>
      </tr>
    <?php
	}
}
?>
    <tr><td colspan="6" align="center">
            <?php
			if($trans_total_pages>$transrecordsperpage)
			{
			echo get_pagination($targetpage,$trans_total_pages,$transrecordsperpage,$pagination,'#option_trans_report');
			}?>
            </td></tr>
  </thead>
</table>
 <?php
}else
{
?>
<strong><?php _e('No Transaction Available'); ?></strong>
      <?php
}
?>
