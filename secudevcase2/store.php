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

		<style>
			
			body{
				background-color: lavender;
			}
		
			label{
				font-size: 18px;
			}
			
			.maint{
				text-align: center;
				width: 95%;
			}
			
			td {
				padding: 12px;
			}
		
			.uinfo{
				width: 20%;
			}
		
			.hovers:hover{
				background-color: #F2F2F2;
			}
			
		</style>
		
		</head>
		
		<body>';

echo "<table class = \"maint\"> <tr> ";

echo "<td class = \"uinfo\" valign=\"top\" >";

echo "<button type=\"button\" class=\"btn btn-warning\" onclick = \"location.href ='./messageboard.php';\">Messageboard</button><br> ";

if($_SESSION['accesslvl'] == "admin"){
	echo "<div class = \"btn-group\">";	

	echo "<button type=\"button\" class=\"btn btn-success\" onclick = \"location.href ='./additem.php';\">Add Item</button> 
			";
	echo "<button type=\"button\" class=\"btn btn-success\" onclick = \"location.href ='./deleteitem.php';\">Delete Item</button>
			";
	echo "<button type=\"button\" class=\"btn btn-primary\" onclick = \"location.href ='./viewtransactions.php';\">View Transactions</button>
			</div>";
}

echo "</td>";

echo "<td rowspan = 2 valign=\"top\" >";

if(isset($_SESSION['paymentresult'])){
	echo $_SESSION['paymentresult'] . '<br><br>';
	unset($_SESSION['paymentresult']);
}

$stmt = $db->prepare("SELECT * FROM items WHERE stock > 0");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Item List:</h2>';

if($stmt->rowCount()>0)
{
	echo '<table class="table">';
	foreach($results as $key=>$row) {
		if($key%4 == 0)
			echo '<tr>';
		echo '<td class = "hovers">';
		echo '<div onclick="location.href=\'./viewitem.php?item_id=' . $row['id'] . '\';" id="item' . $key . '">';
		echo $row['name'] . '<br>' . $row['description'] . '<br>' . $row['price'];
		//$temp = $_SERVER["DOCUMENT_ROOT"] . "/" . $row['imgpath'];
		$temp = "/" . $row['imgpath'];
		echo '<br><img src = "' . $temp . '" style = "width:128px;height:128px">';
		echo '<br><form action="addtocart.php" method="POST">
 			<input type="hidden" name="itemid" value="'. $row['id'] .'">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
 					<br><br>
 			</form>';
		echo '</div>';
		echo "</td>";
		if($key%4 == 3)
			echo '</tr>';
	}
	echo '</table>';
}
else{
	echo	'There are no items available.';
}	

echo "</td>";

echo "</tr>";

echo "<tr>";

echo "<td class = \"uinfo\" valign=\"top\">";

echo 		'<br><br><br>Cart<br>';

//if(isset($_SESSION['cartitems'])){	
	$totalprice = 0.0;
	
	$itemindex = 0;
// 	foreach($_SESSION['cartitems'] as $itemid){
// 		$stmt = $db->prepare("SELECT * FROM items WHERE id = :itemid");
// 		$stmt->execute(array(':itemid' => $itemid));
// 		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
// 			echo	'<tr>
// 						<td>' . $row['name'] . '</td>
// 						<td>' . $row['price'] . '</td>
// 						<td><form action="removefromcart.php" method="POST">
// 								<input type="hidden" name="index" value="' . $itemindex . '">
// 								<input class="btn btn-danger" type="submit" value="Remove"></form></td>
// 					</tr>';
// 		$totalprice += $row['price'];
// 		}
// 		$itemindex++;
		
// 	}
	$stmt = $db->prepare("SELECT items.id, items.name, items.price, quantity FROM carts
			INNER JOIN items
			ON carts.item_id = items.id WHERE acc_id = :itemid");
	$stmt->execute(array(':itemid' => $_SESSION['id']));
	
	if($stmt -> rowCount() > 0){
		echo '<table align = "center">
				<tr>
					<td>Item</td>
					<td>Price</td>
					<td>Quantity</td>
					<td></td>
				</tr>';
	
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			echo	'<tr>
						<td>' . $row['name'] . '</td>
						<td>' . $row['price'] . '</td>
						<td>' . $row['quantity'] . '</td>		
						<td><form action="removefromcart.php" method="POST">
								<input type="hidden" name="itemid" value="' . $row['id'] . '">
								<input class="btn btn-danger" type="submit" value="Remove"></form></td>
					</tr>';
			$totalprice += $row['price'] * $row['quantity'];
			$itemindex++;
		}
		$_SESSION['totalprice'] = $totalprice;
		
		echo	'</table><br>
				Total:' . $totalprice . '<br><br>';
		
		echo	'<form action="checkout.php" method="POST">
					<input class="btn btn-success" type="submit" value="Checkout">
					</form>';
	}	
	else{
		echo	'There are no items in your cart.';
	}
	
//}
//else{
	
// 	$totalprice = 0.0;
// 	echo '<table align = "center">
// 			<tr>
// 				<td>Item</td>
// 				<td>Price</td>
// 				<td></td>
// 			</tr>';
	
// 	$stmt = $db->prepare("SELECT items.name, items.price FROM carts 
// 			INNER JOIN items
// 			ON carts.item_id = items.id WHERE acc_id = :itemid");
// 	$stmt->execute(array(':itemid' => $_SESSION['id']));
// 	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		
// 	}
// 	if($stmt -> rowCount() == 0)
	//echo	'There are no items in your cart.';
//}

echo "</td>";

echo "</tr>";

echo "</table>";

echo	'</body>
		</html>';
?>