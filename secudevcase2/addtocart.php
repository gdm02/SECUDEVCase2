<?php
include 'session.php';
include 'connect.php';

if(isset($_SESSION['cartitems'])){
	$items = $_SESSION['cartitems'];
}
else{
	$items = array();
}

$items[] = $_POST['itemid'];

$_SESSION['cartitems'] = $items;

header("Location: ./store.php"); /* Redirect browser */
exit();


