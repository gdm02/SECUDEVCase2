<?php

include 'session.php';
include 'connect.php';

if($_SESSION['accesslvl'] == "admin"){
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Store</button>
			<br><br><br>";
	echo	'All Transactions<br><br><br>';
	$stmt = $db->prepare("SELECT state,transactions.id, amount, payment_id, description,time, accounts.fname, accounts.lname FROM transactions 
			INNER JOIN accounts 
			ON transactions.acc_id = accounts.id");
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo	'Transaction Details:<br><table>
				<tr>
					<td>Payment ID</td>
					<td>Buyer</td>
					<td>Amount</td>
					<td>Description</td>
					<td>State</td>
					<td>Date</td>
				</tr>
				<tr>
					<td>' . $row['payment_id'] . '</td>
					<td>' . $row['fname'] . ' ' . $row['lname'] . '</td>
					<td>' . $row['amount'] . '</td>
					<td>' . $row['description'] . '</td>
					<td>' . $row['state'] . '</td>
					<td>' . $row['time'] . '</td>
				</tr>	
				</table>	
				';
		echo	'Items bought: <br>';
		$stmt2 = $db->prepare("SELECT items.name, quantity FROM orders 
				INNER JOIN items
				ON orders.item_id = items.id 
				WHERE transaction_id = :trans_id");
		$stmt2->execute(array(':trans_id'=>$row['id']));
		
		while ($item = $stmt2->fetch(PDO::FETCH_ASSOC)){
			echo	$item['name'] . ' x ' . $item['quantity'] . '<br>';
		}
		echo	'<br><br>';
	}
}
else{
	header("Location: ./store.php"); /* Redirect browser */
	exit();
}