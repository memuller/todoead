<?php include DDB_ADMIN_TPL_PATH.'header.php'; ?>
<div class="info top-info"></div>
<div class="ajax-message<?php if ( isset( $message ) ) { echo ' show'; } ?>">
	<?php if ( isset( $message ) ) { echo $message; } ?>
</div>
	<div id="content">
		<div id="options_tabs">
			<ul class="options_tabs">
				<li><a href="#option_saller_report">Seller Report</a><span></span></li>				
				<li><a href="#option_trans_report">Transaction Report</a><span></span></li>				
				<li><a href="#option_deal_report">Deal Report</a><span></span></li>				
							
			</ul> 