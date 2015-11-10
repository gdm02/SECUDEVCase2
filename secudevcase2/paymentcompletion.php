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
			
			//get payment id
			$stmt = $db->prepare("SELECT payment_id,acc_id,amount from transactions WHERE id = :trans_id");
			$stmt->execute(array(':trans_id' => $trans_id));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$payment_id = $row['payment_id'];
				$acc_id = $row['acc_id'];
				$amount = $row['amount'];
			}
			$payment = executePayment($payment_id, $_GET['PayerID']);
			
			//update user stats
			$stmt = $db->prepare("SELECT amount_purchased FROM accounts WHERE id = :id");
			$stmt->execute(array(':id'=>$acc_id));
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$value = $row['amount_purchased'];
				$value += $amount;
			}
			$stmt = $db->prepare("UPDATE accounts SET amount_purchased = :value WHERE id = :id");
			$stmt->execute(array(':value'=>$value,':id' => $acc_id));
			
			//update transaction state
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
		
		//clear cart
		$stmt = $db->prepare("DELETE FROM carts WHERE acc_id = :acc_id");
		$stmt->execute(array(':acc_id' => $acc_id));
		
	} else {
		$messageType = "error";
		$message = "Your payment was cancelled.";
	}
}
echo $message . "<br> Return to <a href='./store.php'>store</a>";

