<?php

include 'session.php';
include 'connect.php';
require_once 'bootstrap.php';

if(isset($_GET['success'])) {
	// We were redirected here from PayPal after the buyer approved/cancelled
	// the payment
	
	if($_GET['success'] == 'true' && isset($_GET['PayerID']) && isset($_GET['trans_id'])) {
		$trans_id = $_GET['trans_id'];
		try {
			$stmt = $db->prepare("SELECT payment_id from transactions WHERE id = :trans_id");
			$stmt->execute(array(':trans_id' => $trans_id));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$payment_id = $row['payment_id'];
			}
			$payment = executePayment($payment_id, $_GET['PayerID']);
			
			//update state
			$stmt = $db->prepare("UPDATE transactions SET state = :state WHERE id = :trans_id");
			$stmt->execute(array(':state'=>$payment->getState(),':trans_id' => $trans_id));
			
			$messageType = "success";
			$message = "Your payment was successful.";
		} catch (\PayPal\Exception\PPConnectionException $ex) {
			$message = parseApiError($ex->getData());
			$messageType = "error";
		} catch (Exception $ex) {
			$message = $ex->getMessage();
			$messageType = "error";
		}
		
		//create orders list
		$itemlist = array();
		$qtylist = array();
		foreach($_SESSION['cartitems'] as $itemid){
			if(!in_array($itemid, $itemlist)){
				$itemlist[] = $itemid;
				$qtylist[] = 1;
			}
			else{
				$key = array_search($itemid, $itemlist);
				$qtylist[$key]++;
			}
		}
		for ($x = 0; $x < count($itemlist); $x++) {
			
			$stmt = $db->prepare("INSERT INTO orders(transaction_id, item_id, quantity)
			VALUES (:trans_id,:item_id,:quantity)");
			$stmt->execute(array(':trans_id' => $trans_id, ':item_id' => $itemlist[$x], ':quantity' => $qtylist[$x]));
		}
		unset($_SESSION['cartitems']);
		
	} else {
		$messageType = "error";
		$message = "Your payment was cancelled. Go back to <a href='./store.php'>store</a>";
	}
}
echo $message . "<br> Return to <a href='./store.php'> store</a>";

