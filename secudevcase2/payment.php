<?php
require_once 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$baseUrl = getBaseUrl() . "/paymentcompletion.php?";
	$payment = makePaymentUsingPayPal($_POST['amount'], $_POST['currency'], $_POST['description'],
			"$baseUrl&success=true", "$baseUrl&success=false");
	
	$_SESSION['PaymentID'] = $payment->getId();
	header("Location: " . getLink($payment->getLinks(), "approval_url") );
	exit;

}
function getBaseUrl() {
	$protocol = 'http';
	if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
		$protocol .= 's';
	}
	$host = $_SERVER['HTTP_HOST'];
	$request = $_SERVER['PHP_SELF'];
	return dirname($protocol . '://' . $host . $request);
}

function getLink(array $links, $type) {
	foreach($links as $link) {
		if($link->getRel() == $type) {
			return $link->getHref();
		}
	}
	return "";
}
