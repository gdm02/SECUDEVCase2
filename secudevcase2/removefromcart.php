<?php

include 'session.php';
include 'connect.php';

if(isset($_SESSION['cartitems'])){
	try{
		$items = $_SESSION['cartitems'];
		array_splice($items, $_POST['index'], 1);
		$_SESSION['cartitems'] = $items;
		if(count($items) == 0){
			unset($_SESSION['cartitems']);
		}
	}
	catch(Exception $e){
		
	}
}

header("Location: ./store.php"); /* Redirect browser */
exit();
