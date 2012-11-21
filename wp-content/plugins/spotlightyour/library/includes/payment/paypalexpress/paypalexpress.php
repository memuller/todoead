<?php
class PaymentExpress
{
    
	var $username = '';
	var $password = '';
	var $URL = "sec.paymentexpress.com/pxpost.aspx";
	
	
	function  PaymentExpress($username,$password){
			$this->username = $username;
			$this->password = $password;
	}
	
	
	//makes auth request.
	function makeAuthRequest($amount = false,$currency, $card_num = false, $exp_date = false, $card_code = false, $card_name = false,$mer_ref='')
    {
		$cmdDoTxnTransaction = '';
		$cmdDoTxnTransaction .= "<Txn>";
		$cmdDoTxnTransaction .= "<PostUsername>{$this->username}</PostUsername>"; #Insert your DPS Username here
		$cmdDoTxnTransaction .= "<PostPassword>{$this->password}</PostPassword>"; #Insert your DPS Password here
		$cmdDoTxnTransaction .= "<Amount>$amount</Amount>";
		$cmdDoTxnTransaction .= "<InputCurrency>$currency</InputCurrency>";
		$cmdDoTxnTransaction .= "<CardHolderName>$card_name</CardHolderName>";
		$cmdDoTxnTransaction .= "<CardNumber>$card_num</CardNumber>";
		$cmdDoTxnTransaction .= "<DateExpiry>$exp_date</DateExpiry>";
		$cmdDoTxnTransaction .= "<Cvc2>$card_code</Cvc2>";
		$cmdDoTxnTransaction .= "<TxnType>Auth</TxnType>";
		$cmdDoTxnTransaction .= "<MerchantReference>$mer_ref</MerchantReference>";
		$cmdDoTxnTransaction .= "</Txn>";
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,"https://".$this->URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$cmdDoTxnTransaction);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Needs to be included if no *.crt is available to verify SSL certificates
		curl_setopt($ch,CURLOPT_SSLVERSION,3);	
		$result = curl_exec ($ch); 
		return simplexml_load_string($result);
    }
	
	//makes complete/capture request
	function makeCompleteRequest($amount = false,$currency,$dps_trans_ref,$mer_ref='')
    {
		$cmdDoTxnTransaction = '';
		$cmdDoTxnTransaction .= "<Txn>";
		$cmdDoTxnTransaction .= "<PostUsername>{$this->username}</PostUsername>"; #Insert your DPS Username here
		$cmdDoTxnTransaction .= "<PostPassword>{$this->password}</PostPassword>"; #Insert your DPS Password here
		$cmdDoTxnTransaction .= "<Amount>$amount</Amount>";
		$cmdDoTxnTransaction .= "<InputCurrency>$currency</InputCurrency>";
		$cmdDoTxnTransaction .= "<TxnType>Complete</TxnType>";
		$cmdDoTxnTransaction .= "<DpsTxnRef>$dps_trans_ref</DpsTxnRef>";
		$cmdDoTxnTransaction .= "<MerchantReference>$mer_ref</MerchantReference>";
		$cmdDoTxnTransaction .= "</Txn>";
		//print_r($cmdDoTxnTransaction);exit;
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,"https://".$this->URL);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$cmdDoTxnTransaction);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //Needs to be included if no *.crt is available to verify SSL certificates
		curl_setopt($ch,CURLOPT_SSLVERSION,3);	
		$result = curl_exec ($ch); 
		return simplexml_load_string($result);
    }
}//end class
