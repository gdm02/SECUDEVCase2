<?php
include 'session.php';
include 'connect.php';



echo 	'<!DOCTYPE html>
		<html lang = "en">
		<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<title>Store</title>

		</head>
		<body>';

echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./messageboard.php';\">Messageboard</button> ";

if($_SESSION['accesslvl'] == "admin"){
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./additem.php';\">Add Item</button> 
			";
	echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./viewtransactions.php';\">View Transactions</button>
			<br><br><br>";
}

if(isset($_SESSION['paymentresult'])){
	echo $_SESSION['paymentresult'] . '<br><br>';
	unset($_SESSION['paymentresult']);
}

$stmt = $db->prepare("SELECT * FROM items WHERE stock > 0");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($stmt->rowCount()>0)
{
	foreach($results as $key=>$row) {
		echo '<div onclick="location.href=\'./viewitem.php?item_id=' . $row['id'] . '\';" id="item' . $key . '">';
		echo $row['name'] . '<br>' . $row['description'] . '<br>' . $row['price'];
		echo '<br><form action="addtocart.php" method="POST">
 			<input type="hidden" name="itemid" value="'. $row['id'] .'">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
 					<br><br>
 			</form>';
		echo '</div>';
	}
}
else{
	echo	'There are no items available.';
}	

echo 		'<br><br><br>Cart<br>';



if(isset($_SESSION['cartitems'])){	
	$totalprice = 0.0;
	echo '<table>
			<tr>
				<td>Item</td>
				<td>Price</td>
				<td></td>
			</tr>';
	$itemindex = 0;
	foreach($_SESSION['cartitems'] as $itemid){
		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
		$stmt->execute(array(':itemid' => $itemid));
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo	'<tr>
						<td>' . $row['name'] . '</td>
						<td>' . $row['price'] . '</td>
						<td><form action="removefromcart.php" method="POST">
								<input type="hidden" name="index" value="' . $itemindex . '">
								<input type="submit" value="Remove"></form></td>
					</tr>';
		$totalprice += $row['price'];
		}
		$itemindex++;
		
	}
	$_SESSION['totalprice'] = $totalprice;
	
	echo	'</table><br>
		Total:' . $totalprice . '<br><br>';

	echo	'<form action="checkout.php" method="POST">
			<input type="submit" value="Checkout">
			</form>';
}
else{
	echo	'There are no items in your cart.';
}
echo	'</body>
		</html>';
