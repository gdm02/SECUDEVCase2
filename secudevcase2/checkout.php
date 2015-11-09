<?php

include 'session.php';
include 'connect.php';

echo	'Confirm Payment<br><br><br>';

if(isset($_SESSION['cartitems'])){
	$totalprice = 0.0;
	echo '<table>
			<tr>
				<td>Item</td>
				<td>Price</td>
				<td>Quantity</td>
				<td>Amount</td>
			</tr>';
	$itemindex = 0;
	
	$itemlist = array();
	foreach($_SESSION['cartitems'] as $itemid){
		if(!array_key_exists($itemid, $itemlist)){
			$itemlist[$itemid] = 1;
		}
		else{
			$itemlist[$itemid]++;
		}
	}
	
	foreach($itemlist as $key => $value){
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
		$stmt->execute(array(':itemid' => $key));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo	'<tr>
						<td>' . $row['name'] . '</td>
						<td>' . $row['price'] . '</td>
						<td> x' . $value . '</td>
						<td>' . number_format((float)($value * $row['price']), 2, '.', '') . '</td>
					</tr>';
			
		}
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