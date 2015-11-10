<?php
include 'session.php';
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemid'])) {
// 	if(isset($_SESSION['cartitems'])){
// 		$items = $_SESSION['cartitems'];
// 	}
// 	else{
// 		$items = array();
// 	}
	try{
	//$items[] = $_POST['itemid'];
	$query = "SELECT id, quantity FROM carts WHERE acc_id = :acc_id AND item_id = :item_id";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':item_id' => $_POST['itemid']));
	if($stmt -> rowCount() > 0){
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$id = $row['id'];
			$value = $row['quantity'];
			$value++;
			$stmt = $db->prepare("UPDATE carts SET quantity = :value WHERE id = :id");
			$stmt->execute(array(':value'=>$value,':id' => $id));
		}
	}
	else{
		$query = "INSERT INTO carts (acc_id,item_id,quantity) VALUES (:acc_id,:item_id,:quantity)";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':acc_id' => $_SESSION['id'], 
				':item_id' => $_POST['itemid'], ':quantity' => 1));
	}
	}catch(Exception $e){
		echo $e;
	}
	//$_SESSION['cartitems'] = $items;
}
header("Location: ./store.php"); /* Redirect browser */
exit();


