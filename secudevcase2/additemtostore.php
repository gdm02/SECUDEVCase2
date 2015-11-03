<?php

include 'session.php';
include 'connect.php';
include_once 'library/HTMLPurifier.auto.php';

if($_SESSION['accesslvl'] == "admin"){
	$result = 'Item added to store.';
	$purifier = new HTMLPurifier();
	
	$query = "INSERT INTO items (name,price,description,stock) VALUES(
			:name, :price, :description, :stock)";
	
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':name' => $purifier->purify($_POST['name']),':price' => $purifier->purify($_POST['price']),
				':description' => $purifier->purify($_POST['description']),':stock' => $purifier->purify($_POST['stock'])));
	}
	catch(PDOException $e){
		$result = 'Failed to add item';
	}
}
$_SESSION['addresult'] = $result;
header("Location: ./additem.php"); /* Redirect browser */
exit();


