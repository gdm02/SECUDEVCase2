<?php

include 'session.php';
include 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['itemid'])) {
	$query = "DELETE FROM carts WHERE acc_id = :acc_id AND item_id = :item_id";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':acc_id' => $_SESSION['id'], ':item_id' => $_POST['itemid']));
}

header("Location: ./store.php"); /* Redirect browser */
exit();
