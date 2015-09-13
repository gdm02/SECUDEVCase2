<?php
    //$servername = 'localhost';
	$servername = '127.0.0.1';
	$username   = 'root';
	$password   = '1234';
	$database   = 'forum';
	
	try{
		$db = new PDO('mysql:host=' . $servername . ';dbname=' . $database . ';charset=utf8', $username, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
	catch(PDOException $e){
		header("Location: error.php"); /* Redirect browser */
		exit();
	}
?>
