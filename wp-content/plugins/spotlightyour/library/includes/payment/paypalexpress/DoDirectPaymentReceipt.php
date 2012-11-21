<?php
/***********************************************************
DoDirectPaymentReceipt.php

Submits a credit card transaction to PayPal using a
DoDirectPayment request.

The code collects transaction parameters from the form
displayed by DoDirectPayment.php then constructs and sends
the DoDirectPayment request string to the PayPal server.
The paymentType variable becomes the PAYMENTACTION parameter
of the request string.

After the PayPal server returns the response, the code
displays the API request and response in the browser.
If the response from PayPal was a success, it displays the
response parameters. If the response was an error, it
displays the errors.

Called by DoDirectPayment.php.

Calls CallerService.php and APIError.php.

***********************************************************/

require_once 'CallerService.php';
if (!session_id()){ session_start();}


/**
 * Get required parameters from the web form for the request
 */
$paymentType =urlencode('Authorization');
$firstName =urlencode('Arsalan');
$lastName =urlencode('khan');
$creditCardType =urlencode('visa');
$creditCardNumber = urlencode('4752831574228896');
$expDateMonth =urlencode('12');

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode('2012');
//$cvv2Number = urlencode('6548');
$address1 = urlencode('abc');
$address2 = urlencode('address2');
$city = urlencode('lucknow');
$state =urlencode('NY');
$zip = urlencode('6412514');
$amount = urlencode('10.00');
//$currencyCode=urlencode($_POST['currency']);
$currencyCode="USD";
$paymentType=urlencode('Authorization');

/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".         $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";



/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
$resArray=hash_call("doDirectPayment",$nvpstr);
print_r($resArray);exit;
/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
$ack = strtoupper($resArray["ACK"]);

if($ack!="SUCCESS")  {
    $_SESSION['reshash']=$resArray;
	$location = "APIError.php";
		 header("Location: $location");
   }

?>

<html>
<head>
    <title>PayPal PHP SDK - DoDirectPayment API</title>
    <link href="sdk.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<br>
	<center>
	<font size=2 color=black face=Verdana><b>Do Direct Payment</b></font>
	<br><br>

	<b>Thank you for your payment!</b><br><br>
	
   <table width=400>

        <?php 
   		 	require_once 'ShowAllResponse.php';
   		 ?>
    </table>
    </center>
    <a class="home" id="CallsLink" href="index.html">Home</a>
</body>




