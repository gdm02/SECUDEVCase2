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
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
		$stmt->execute(array(':itemid' => $itemlist[$x]));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo	'<tr>
						<td>' . $row['name'] . '</td>
						<td>' . $row['price'] . '</td>
						<td> x' . $qtylist[$x] . '</td>
						<td>' . number_format((float)($qtylist[$x] * $row['price']), 2, '.', '') . '</td>
					</tr>';
			
		}
		$itemindex++;
	}
	$totalprice = $_SESSION['totalprice'];
	//$_SESSION['totalprice'] = $totalprice;

	echo	'</table><br>
		Total:' . $totalprice . '<br><br>';

	echo	'<form action="payment.php" method="POST">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>';
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./store.php';\">Cancel</button>
			";
}