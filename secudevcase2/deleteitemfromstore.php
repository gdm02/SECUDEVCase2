<?php
include 'session.php';
include 'connect.php';
include_once 'library/HTMLPurifier.auto.php';


if($_SESSION['accesslvl'] == "admin"){
	$result = "Item removed from store.";
	$query = "DELETE FROM items WHERE id = :id";
	
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':id' => $_POST['itemid']));
	}
	catch(PDOException $e){
		$result = "Error in removing item. Please try again.";
	}
}
$_SESSION['deleteresult'] = $result;
header("Location: ./deleteitem.php"); /* Redirect browser */
exit();