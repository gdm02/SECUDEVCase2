<?php
include 'session.php';
include 'connect.php';
require_once 'bootstrap.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	//create orders list
	$itemlist = array();
	$stmt = $db->prepare("SELECT items.id, items.name, items.price, quantity FROM carts
			INNER JOIN items
			ON carts.item_id = items.id WHERE acc_id = :itemid");
	$stmt->execute(array(':itemid' => $_SESSION['id']));
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$itemlist[$row['id']] = $row['quantity'];
	}
	
	$stmt = $db->prepare("INSERT INTO transactions(payment_id,acc_id,amount,state,description,time) 
			VALUES (:payment_id,:acc_id,:amount,:state,:description, NOW())");
	$stmt->execute(array(':payment_id'=>NULL,':acc_id'=>$_SESSION['id'],
			':amount'=>$_SESSION['totalprice'],':state'=>NULL,':description'=>'Payment by Paypal'));
	$trans_id = $db->lastInsertId();
	
	
	try{
		// Create the payment and redirect buyer to paypal for payment approval.
		$baseUrl = getBaseUrl() . "/paymentcompletion.php?trans_id=$trans_id";
		$payment = makePaymentUsingPayPal($_SESSION['totalprice'], 'USD', 'Payment by Paypal', $itemlist, $db,
				"$baseUrl&success=true", "$baseUrl&success=false");
		$stmt = $db->prepare("UPDATE transactions SET payment_id = :payment_id, state = :state WHERE id = :id");
		$stmt->execute(array(':payment_id'=>$payment->getId(),':state'=>$payment->getState(),':id'=>$trans_id));
		
		foreach($itemlist as $key => $value){
			$stmt = $db->prepare("INSERT INTO orders(transaction_id, item_id, quantity)
 			VALUES (:trans_id,:item_id,:quantity)");
			$stmt->execute(array(':trans_id' => $trans_id, ':item_id' => $key, ':quantity' => $value));
		}
		
		header("Location: " . getLink($payment->getLinks(), "approval_url") );
		exit;
	} catch (PayPal\Exception\PayPalConnectionException $ex) {
		$_SESSION['paymentresult'] = 'Error in processing payment. Please try again.';
		header("Location: ./store.php"); /* Redirect browser */
		exit();
	}
	catch(Exception $e){
		$_SESSION['paymentresult'] = 'Error in processing payment. Please try again.';
		header("Location: ./store.php"); /* Redirect browser */
		exit();
	}
	
	
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
/*
function addTransaction($acc_id, $payment_id, $state, $amount, $description) {

	$stmt = $db->prepare("INSERT INTO transactions(payment_id,acc_id,amount,state,description,time) 
			VALUES(:payment_id,:acc_id,:amount,:state,:description, NOW()");
	$stmt->execute(array(':payment_id'=>$payment_id,':acc_id'=>$acc_id,
			':amount'=>$amount,':state'=>$state,':description'=>$description));
	return $db->lastInsertId();
}
function updateTransaction($transaction_id, $payment_id, $state){
	$stmt = $db->prepare("UPDATE transactions SET payment_id = :payment_id, state = :state WHERE id = :id");
	$stmt->execute(array(':payment_id'=>$payment_id,':state'=>$state,':id'=>$transaction_id));
}
*/
