<?php

include 'session.php';
include 'connect.php';

echo	'Confirm Payment<br><br><br>';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$totalprice = 0.0;
	echo '<table>
			<tr>
				<td>Item</td>
				<td>Price</td>
				<td>Quantity</td>
				<td>Amount</td>
			</tr>';
	
	$stmt = $db->prepare("SELECT items.id, items.name, items.price, quantity FROM carts
			INNER JOIN items
			ON carts.item_id = items.id WHERE acc_id = :itemid");
	$stmt->execute(array(':itemid' => $_SESSION['id']));
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){		
		echo	'<tr>
						<td>' . $row['name'] . '</td>
						<td>' . $row['price'] . '</td>
						<td> x' . $row['quantity'] . '</td>
						<td>' . number_format((float)($row['quantity'] * $row['price']), 2, '.', '') . '</td>
					</tr>';
	}
	
	$totalprice = $_SESSION['totalprice'];
	
	echo	'</table><br>
		Total:' . $totalprice . '<br><br>';

	echo	'<form action="payment.php" method="POST">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>';
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Cancel</button>
			";
}