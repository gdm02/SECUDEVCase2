<?php
require_once 'bootstrap.php';

if($_GET['success'] == 'true' && isset($_GET['PayerID']) && issetd($_GET['paymentid'])) {
		try {
			$payment = executePayment($_GET['paymentid'], $_GET['PayerID']);
			$messageType = "success";
			$message = "Your payment was successful.";
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			$message = parseApiError($ex->getData());
			$messageType = "error";
		} catch (Exception $ex) {
			$message = $ex->getMessage();
			$messageType = "error";
		}
		
} else {
	echo "else";
	$messageType = "error";
	$message = "Your payment was cancelled.";
}
echo $message . "<br> Return to <a href='messageboard.php'> messageboard</a>";

//function getPaymentId